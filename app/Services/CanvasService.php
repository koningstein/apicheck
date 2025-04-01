<?php

namespace App\Services;

use App\Models\CanvasSetting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CanvasService
{
    protected $apiUrl;
    protected $apiToken;

    public function __construct()
    {
        // Haal de actieve Canvas instelling op uit de database
        $settings = CanvasSetting::where('active', true)->first();

        if (!$settings) {
            Log::error('Geen actieve Canvas API-instellingen gevonden');
            throw new \Exception('Geen actieve Canvas API-instellingen gevonden');
        }

        $this->apiUrl = rtrim($settings->apiurl, '/');
        $this->apiToken = $settings->apitoken;
    }

    /**
     * Test de verbinding met Canvas API door cursussen op te halen
     */
    public function testConnection()
    {
        try {
            // Probeer om slechts één cursus op te halen (indien mogelijk)
            $response = Http::withOptions([
                'verify' => false,
            ])->withHeaders([
                'Authorization' => 'Bearer ' . $this->apiToken,
            ])->get($this->apiUrl . '/api/v1/courses', [
                'per_page' => 1
            ]);

            // Log de status en resultaat (voor debugging)
            Log::debug("Canvas API Test Response Status: " . $response->status());

            if ($response->successful()) {
                $courses = $response->json();
                $coursesCount = is_array($courses) ? count($courses) : 0;

                Log::info("Canvas API: Verbinding getest - Succesvol verbonden. {$coursesCount} cursussen gevonden.");

                return [
                    'success' => true,
                    'message' => 'Verbinding succesvol',
                    'courses_count' => $coursesCount,
                    'first_course' => $coursesCount > 0 ? $courses[0]['name'] : null
                ];
            } else {
                $error = $response->body();
                $status = $response->status();

                Log::error("Canvas API Verbindingstest mislukt (HTTP {$status}): " . $error);

                return [
                    'success' => false,
                    'message' => 'Verbinding mislukt: HTTP status ' . $status,
                    'error' => $error,
                    'status' => $status
                ];
            }
        } catch (\Exception $e) {
            Log::error("Canvas API Verbindingstest Exception: " . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Verbinding mislukt door een fout',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Haal een lijst van cursussen op
     * @param int $limit Optioneel limiet voor aantal cursussen (standaard alle)
     * @return array|null
     */
    public function getCourses($limit = null)
    {
        try {
            $allCourses = [];
            $page = 1;
            $perPage = 100; // Maximum voor de meeste Canvas API's
            $hasMorePages = true;

            while ($hasMorePages) {
                $response = Http::withOptions([
                    'verify' => false, // Belangrijk: SSL-verificatie uitschakelen
                ])->withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiToken,
                ])->get($this->apiUrl . '/api/v1/courses', [
                    'per_page' => $perPage,
                    'page' => $page,
                    'include' => ['total_students'] // Vraag student aantallen op voor efficiëntie
                ]);

                if ($response->failed()) {
                    Log::error('API-aanroep getCourses mislukt: ' . $response->body());
                    return $allCourses; // Retourneer wat we tot nu toe hebben
                }

                $coursesPage = $response->json();

                if (empty($coursesPage)) {
                    $hasMorePages = false;
                } else {
                    $allCourses = array_merge($allCourses, $coursesPage);
                    $page++;

                    // Stop als we genoeg cursussen hebben
                    if ($limit && count($allCourses) >= $limit) {
                        $allCourses = array_slice($allCourses, 0, $limit);
                        $hasMorePages = false;
                    }

                    // Check of er nog meer pagina's zijn via Link header
                    $linkHeader = $response->header('Link');
                    if ($linkHeader && !str_contains($linkHeader, 'rel="next"')) {
                        $hasMorePages = false;
                    }
                }
            }

            Log::info('API-aanroep Gelukt: ' . count($allCourses) . ' cursussen opgehaald.');
            return $allCourses;
        } catch (\Exception $e) {
            Log::error('Exception bij het ophalen van cursussen: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Sorteer cursussen op aantal studenten (hoogste eerst)
     * @param array $courses Array van cursussen
     * @return array Gesorteerde cursussen
     */
    protected function sortCoursesByStudentCount(array $courses): array
    {
        usort($courses, function($a, $b) {
            $aCount = $a['total_students'] ?? 0;
            $bCount = $b['total_students'] ?? 0;
            return $bCount - $aCount; // Sorteer aflopend
        });

        return $courses;
    }

    /**
     * Zoek Canvas ID voor een student op basis van Eduarte ID via cursus-inschrijvingen
     * @param string $eduarteId
     * @param bool $sortByStudentCount Of cursussen gesorteerd moeten worden op aantal studenten
     * @return string|null Canvas ID indien gevonden, anders null
     */
    public function getCanvasIdByEduarteId(string $eduarteId, bool $sortByStudentCount = true): ?string
    {
        try {
            // 1. Haal alle beschikbare cursussen op
            $courses = $this->getCourses();

            if (empty($courses)) {
                Log::warning("Geen cursussen gevonden om te zoeken naar student Eduarte ID: $eduarteId");
                return null;
            }

            Log::info("Start zoeken naar Canvas ID voor Eduarte ID: $eduarteId in " . count($courses) . " cursussen");

            // Sorteer op aantal studenten als gewenst
            if ($sortByStudentCount) {
                $courses = $this->sortCoursesByStudentCount($courses);
                Log::info("Cursussen gesorteerd op aantal studenten. Top cursus heeft " .
                    ($courses[0]['total_students'] ?? 'onbekend') . " studenten.");
            }

            // 2. Loop door elke cursus en controleer de ingeschreven studenten
            foreach ($courses as $course) {
                $courseId = $course['id'];
                $courseName = $course['name'] ?? 'Onbekend';

                Log::info("Zoeken naar Eduarte ID $eduarteId in cursus '$courseName' (ID: $courseId)");

                // 3. Haal alle ingeschreven gebruikers op voor deze cursus
                $response = Http::withOptions([
                    'verify' => false,
                ])->withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiToken,
                ])->get($this->apiUrl . '/api/v1/courses/' . $courseId . '/users', [
                    'enrollment_type' => 'student',
                    'include' => ['email', 'enrollments', 'sis_user_id'],
                    'per_page' => 100 // Maximaal aantal resultaten per pagina
                ]);

                if (!$response->successful()) {
                    Log::warning("Kon geen studenten ophalen voor cursus ID $courseId: " . $response->status());
                    continue; // Ga door naar de volgende cursus
                }

                $users = $response->json();

                // Controleer of er gebruikers zijn gevonden
                if (empty($users)) {
                    Log::info("Geen studenten gevonden in cursus '$courseName'");
                    continue; // Ga door naar de volgende cursus
                }

                Log::info("Gevonden: " . count($users) . " studenten in cursus '$courseName'");

                // 4. Zoek naar een student met het juiste Eduarte ID
                foreach ($users as $user) {
                    // Controleer de verschillende plaatsen waar het Eduarte ID kan staan

                    // Controleer in sis_user_id
                    if (!empty($user['sis_user_id']) && $user['sis_user_id'] === $eduarteId) {
                        Log::info("Canvas ID gevonden in sis_user_id voor Eduarte ID $eduarteId: " . $user['id']);
                        return (string) $user['id'];
                    }

                    // Controleer in login_id
                    if (!empty($user['login_id']) && $user['login_id'] === $eduarteId) {
                        Log::info("Canvas ID gevonden in login_id voor Eduarte ID $eduarteId: " . $user['id']);
                        return (string) $user['id'];
                    }

                    // Controleer in email (soms bevat email adres het ID)
                    if (!empty($user['email']) && strpos($user['email'], $eduarteId) !== false) {
                        Log::info("Canvas ID gevonden in email voor Eduarte ID $eduarteId: " . $user['id']);
                        return (string) $user['id'];
                    }

                    // Controleer in integraties/SIS data
                    if (!empty($user['enrollments'])) {
                        foreach ($user['enrollments'] as $enrollment) {
                            if (!empty($enrollment['sis_user_id']) && $enrollment['sis_user_id'] === $eduarteId) {
                                Log::info("Canvas ID gevonden in enrollment sis_user_id voor Eduarte ID $eduarteId: " . $user['id']);
                                return (string) $user['id'];
                            }
                        }
                    }

                    // Controleer in naam (soms wordt het ID in de naam opgenomen)
                    if (!empty($user['name']) && strpos($user['name'], $eduarteId) !== false) {
                        Log::info("Canvas ID gevonden in name voor Eduarte ID $eduarteId: " . $user['id']);
                        return (string) $user['id'];
                    }

                    // Controleer in sortable_name (soms wordt het ID hier opgenomen)
                    if (!empty($user['sortable_name']) && strpos($user['sortable_name'], $eduarteId) !== false) {
                        Log::info("Canvas ID gevonden in sortable_name voor Eduarte ID $eduarteId: " . $user['id']);
                        return (string) $user['id'];
                    }
                }

                // Controleer of er paginering is
                $linkHeader = $response->header('Link');
                if ($linkHeader && str_contains($linkHeader, 'rel="next"')) {
                    Log::info("Meer pagina's beschikbaar voor cursus $courseId, maar huidige implementatie checkt alleen de eerste pagina.");
                    // Hier zouden we paginering kunnen implementeren, maar dat maakt de functie complexer
                }
            }

            // Als we hier komen is er geen match gevonden in alle cursussen
            Log::info("Geen Canvas ID gevonden voor Eduarte ID: $eduarteId na zoeken in alle cursussen");
            return null;

        } catch (\Exception $e) {
            Log::error("Exception bij zoeken Canvas ID: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Test functie die gedetailleerde informatie geeft over het zoeken naar een Canvas ID
     * @param string $eduarteId
     * @return array Uitgebreide testresultaten
     */
    public function testFindCanvasId(string $eduarteId)
    {
        Log::info("Start uitgebreide test om Canvas ID te vinden voor Eduarte ID: $eduarteId");

        $results = [
            'eduarte_id' => $eduarteId,
            'success' => false,
            'canvas_id' => null,
            'search_log' => [],
            'courses_checked' => 0,
            'students_checked' => 0,
            'time_taken' => 0,
            'errors' => []
        ];

        $startTime = microtime(true);

        try {
            // Voeg een handler toe voor logs
            $previousLogHandler = Log::beforeLogging(function ($level, $message, $context) use (&$results) {
                if (str_contains($message, $results['eduarte_id'])) {
                    $results['search_log'][] = [
                        'level' => $level,
                        'message' => $message
                    ];
                }
            });

            // Haal cursussen op
            $courses = $this->getCourses();

            if (empty($courses)) {
                $results['search_log'][] = [
                    'level' => 'warning',
                    'message' => "Geen cursussen gevonden om te zoeken"
                ];
                $results['errors'][] = "Geen cursussen gevonden";

                // Reset log handler
                Log::beforeLogging($previousLogHandler);

                $results['time_taken'] = round(microtime(true) - $startTime, 2);
                return $results;
            }

            // Sorteer op aantal studenten
            $courses = $this->sortCoursesByStudentCount($courses);

            $results['search_log'][] = [
                'level' => 'info',
                'message' => "Start zoeken in " . count($courses) . " cursussen, gesorteerd op aantal studenten"
            ];

            // Loop door cursussen en zoek naar student
            foreach ($courses as $course) {
                $courseId = $course['id'];
                $courseName = $course['name'] ?? 'Onbekend';
                $studentCount = $course['total_students'] ?? 'onbekend';

                $results['search_log'][] = [
                    'level' => 'info',
                    'message' => "Controleren van cursus '$courseName' (ID: $courseId) met $studentCount studenten"
                ];

                $results['courses_checked']++;

                try {
                    // Haal studenten op
                    $response = Http::withOptions([
                        'verify' => false,
                    ])->withHeaders([
                        'Authorization' => 'Bearer ' . $this->apiToken,
                    ])->get($this->apiUrl . '/api/v1/courses/' . $courseId . '/users', [
                        'enrollment_type' => 'student',
                        'include' => ['email', 'enrollments', 'sis_user_id'],
                        'per_page' => 100
                    ]);

                    if (!$response->successful()) {
                        $results['search_log'][] = [
                            'level' => 'warning',
                            'message' => "Kon geen studenten ophalen voor cursus ID $courseId: " . $response->status()
                        ];
                        $results['errors'][] = "Fout bij ophalen studenten voor cursus $courseId: " . $response->status();
                        continue;
                    }

                    $users = $response->json();

                    if (empty($users)) {
                        $results['search_log'][] = [
                            'level' => 'info',
                            'message' => "Geen studenten gevonden in cursus '$courseName'"
                        ];
                        continue;
                    }

                    $results['students_checked'] += count($users);
                    $results['search_log'][] = [
                        'level' => 'info',
                        'message' => "Controleren van " . count($users) . " studenten in cursus '$courseName'"
                    ];

                    // Zoek naar de student
                    foreach ($users as $user) {
                        $matchField = null;
                        $matchValue = null;
                        $found = false;

                        // Controleer diverse velden
                        if (!empty($user['sis_user_id']) && $user['sis_user_id'] === $eduarteId) {
                            $matchField = 'sis_user_id';
                            $matchValue = $user['sis_user_id'];
                            $found = true;
                        }
                        elseif (!empty($user['login_id']) && $user['login_id'] === $eduarteId) {
                            $matchField = 'login_id';
                            $matchValue = $user['login_id'];
                            $found = true;
                        }
                        elseif (!empty($user['email']) && strpos($user['email'], $eduarteId) !== false) {
                            $matchField = 'email';
                            $matchValue = $user['email'];
                            $found = true;
                        }
                        elseif (!empty($user['enrollments'])) {
                            foreach ($user['enrollments'] as $enrollment) {
                                if (!empty($enrollment['sis_user_id']) && $enrollment['sis_user_id'] === $eduarteId) {
                                    $matchField = 'enrollment.sis_user_id';
                                    $matchValue = $enrollment['sis_user_id'];
                                    $found = true;
                                    break;
                                }
                            }
                        }
                        elseif (!empty($user['name']) && strpos($user['name'], $eduarteId) !== false) {
                            $matchField = 'name';
                            $matchValue = $user['name'];
                            $found = true;
                        }
                        elseif (!empty($user['sortable_name']) && strpos($user['sortable_name'], $eduarteId) !== false) {
                            $matchField = 'sortable_name';
                            $matchValue = $user['sortable_name'];
                            $found = true;
                        }

                        if ($found) {
                            $results['search_log'][] = [
                                'level' => 'info',
                                'message' => "Canvas ID gevonden in $matchField voor Eduarte ID $eduarteId: " . $user['id']
                            ];

                            $results['success'] = true;
                            $results['canvas_id'] = (string) $user['id'];
                            $results['match_field'] = $matchField;
                            $results['match_value'] = $matchValue;
                            $results['user_detail'] = [
                                'id' => $user['id'],
                                'name' => $user['name'] ?? 'Onbekend',
                                'login_id' => $user['login_id'] ?? null,
                                'sis_user_id' => $user['sis_user_id'] ?? null,
                                'email' => $user['email'] ?? null
                            ];

                            // Reset log handler
                            Log::beforeLogging($previousLogHandler);

                            $results['time_taken'] = round(microtime(true) - $startTime, 2);
                            return $results;
                        }
                    }
                } catch (\Exception $e) {
                    $results['search_log'][] = [
                        'level' => 'error',
                        'message' => "Fout bij controleren van cursus $courseId: " . $e->getMessage()
                    ];
                    $results['errors'][] = "Exception bij controleren cursus $courseId: " . $e->getMessage();
                }
            }

            // Reset log handler
            Log::beforeLogging($previousLogHandler);

            $results['search_log'][] = [
                'level' => 'info',
                'message' => "Geen Canvas ID gevonden voor Eduarte ID: $eduarteId na zoeken in alle cursussen"
            ];

        } catch (\Exception $e) {
            $results['search_log'][] = [
                'level' => 'error',
                'message' => "Algemene fout bij zoeken Canvas ID: " . $e->getMessage()
            ];
            $results['errors'][] = "Algemene exception: " . $e->getMessage();

            // Zorg ervoor dat de log handler altijd wordt gereset
            if (isset($previousLogHandler)) {
                Log::beforeLogging($previousLogHandler);
            }
        }

        $results['time_taken'] = round(microtime(true) - $startTime, 2);
        return $results;
    }
}
