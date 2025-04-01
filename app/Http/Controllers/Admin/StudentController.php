<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentStoreRequest;
use App\Http\Requests\StudentUpdateRequest;
use App\Models\Student;
use App\Services\CanvasService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Throwable;

class StudentController extends Controller
{
    protected CanvasService $canvasService;

    public function __construct(CanvasService $canvasService)
    {
        $this->canvasService = $canvasService;
    }

    /**
     * Display a listing of the resource.
     * @return View
     */
    public function index(): View
    {
        $students = Student::paginate(15);
        return view('admin.students.index', ['students' => $students]);
    }

    /**
     * Show the form for creating a new resource.
     * @return View
     */
    public function create(): View
    {
        return view('admin.students.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  StudentStoreRequest  $request
     * @return RedirectResponse
     */
    public function store(StudentStoreRequest $request): RedirectResponse
    {
        $student = new Student();
        $student->eduarteid = $request->eduarteid;
        $student->isactive = $request->has('isactive');

        // Probeer om het Canvas ID op te halen als het niet is ingevuld
        if (empty($request->canvasid)) {
            try {
                // Probeer eerst de reguliere methode
                $canvasId = $this->canvasApiService->getCanvasIdByEduarteId($request->eduarteid);

                // Als dat niet werkt, probeer de directe methode
                if (empty($canvasId)) {
                    $canvasId = $this->canvasApiService->getCanvasIdByEduarteIdDirect($request->eduarteid);
                }

                if ($canvasId) {
                    $student->canvasid = $canvasId;
                }
            } catch (\Exception $e) {
                // Log de fout maar laat het proces doorgaan
                \Log::error('Fout bij ophalen Canvas ID: ' . $e->getMessage());
            }
        } else {
            // Als Canvas ID handmatig is ingevuld, gebruik die
            $student->canvasid = $request->canvasid;
        }

        $student->save();

        $message = "Student met ID $student->eduarteid is aangemaakt.";
        if (empty($student->canvasid)) {
            $message .= " Canvas ID kon niet automatisch worden gevonden.";
        }

        return to_route('admin.students.index')->with('status', $message);
    }

    /**
     * Display the specified resource.
     * @param  Student  $student
     * @return View
     */
    public function show(Student $student): View
    {
        // Load enrollments with related data
        $student->load(['enrollments.crebo', 'enrollments.cohort', 'enrollments.status']);

        return view('admin.students.show', ['student' => $student]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  Student  $student
     * @return View
     */
    public function edit(Student $student): View
    {
        return view('admin.students.edit', ['student' => $student]);
    }

    /**
     * Update the specified resource in storage.
     * @param  StudentUpdateRequest  $request
     * @param  Student  $student
     * @return RedirectResponse
     */
    public function update(StudentUpdateRequest $request, Student $student): RedirectResponse
    {
        $student->eduarteid = $request->eduarteid;
        $student->isactive = $request->has('isactive');

        // Als geen Canvas ID is ingevuld, probeer het op te halen
        if (empty($request->canvasid)) {
            try {
                // Probeer eerst de reguliere methode
                $canvasId = $this->canvasApiService->getCanvasIdByEduarteId($request->eduarteid);

                // Als dat niet werkt, probeer de directe methode
                if (empty($canvasId)) {
                    $canvasId = $this->canvasApiService->getCanvasIdByEduarteIdDirect($request->eduarteid);
                }

                if ($canvasId) {
                    $student->canvasid = $canvasId;
                }
            } catch (\Exception $e) {
                // Log de fout maar laat het proces doorgaan
                \Log::error('Fout bij ophalen Canvas ID: ' . $e->getMessage());
            }
        } else {
            // Als Canvas ID handmatig is ingevuld, gebruik die
            $student->canvasid = $request->canvasid;
        }

        $student->save();

        $message = "Student met ID $student->eduarteid is bijgewerkt.";
        if (empty($student->canvasid)) {
            $message .= " Canvas ID kon niet automatisch worden gevonden.";
        }

        return to_route('admin.students.index')->with('status', $message);
    }

    /**
     * Show the form for deleting the specified resource.
     * @param  Student  $student
     * @return View
     */
    public function delete(Student $student): View
    {
        return view('admin.students.delete', ['student' => $student]);
    }

    /**
     * Remove the specified resource from storage.
     * @param  Student  $student
     * @return RedirectResponse
     */
    public function destroy(Student $student): RedirectResponse
    {
        try {
            $student->delete();
        } catch (Throwable $error) {
            report($error);
            return to_route('admin.students.index')->with('status-wrong', 'Student kan niet worden verwijderd omdat deze in gebruik is.');
        }
        return to_route('admin.students.index')->with('status', "Student met ID $student->eduarteid is verwijderd");
    }

    /**
     * Zoek en update Canvas ID voor een bestaande student
     * @param Student $student
     * @return RedirectResponse
     */
    public function findCanvasId(Student $student): RedirectResponse
    {
        try {
            // Probeer eerst de reguliere methode
            $canvasId = $this->canvasApiService->getCanvasIdByEduarteId($student->eduarteid);

            // Als dat niet werkt, probeer de directe methode
            if (empty($canvasId)) {
                $canvasId = $this->canvasApiService->getCanvasIdByEduarteIdDirect($student->eduarteid);
            }

            if ($canvasId) {
                $student->canvasid = $canvasId;
                $student->save();
                return redirect()->back()->with('status', "Canvas ID succesvol gevonden en bijgewerkt: $canvasId");
            } else {
                return redirect()->back()->with('status-wrong', "Geen Canvas ID gevonden voor deze student.");
            }
        } catch (\Exception $e) {
            report($e);
            return redirect()->back()->with('status-wrong', "Fout bij zoeken Canvas ID: " . $e->getMessage());
        }
    }

    /**
     * Test de Canvas API verbinding
     * @return View|\Illuminate\Http\JsonResponse
     */
    public function testCanvasApi()
    {
        try {
            $result = $this->canvasApiService->testConnection();

            if ($result['success']) {
                // Test een student ID
                $eduarteId = '9023396'; // Gebruik het ID dat mislukte
                $canvasId = $this->canvasApiService->getCanvasIdByEduarteId($eduarteId);
                $directCanvasId = $this->canvasApiService->getCanvasIdByEduarteIdDirect($eduarteId);

                $testData = [
                    'api_connection' => $result,
                    'student_test' => [
                        'eduarte_id' => $eduarteId,
                        'standard_method' => [
                            'canvas_id_found' => !empty($canvasId),
                            'canvas_id' => $canvasId,
                        ],
                        'direct_method' => [
                            'canvas_id_found' => !empty($directCanvasId),
                            'canvas_id' => $directCanvasId,
                        ]
                    ],
                    'logs' => $this->getRecentLogs()
                ];

                // Controleer of het een AJAX-verzoek is
                if (request()->ajax() || request()->wantsJson()) {
                    return response()->json($testData);
                }

                return view('admin.canvas-test', [
                    'testData' => $testData,
                    'success' => true
                ]);
            } else {
                $failData = [
                    'api_connection' => $result,
                    'logs' => $this->getRecentLogs()
                ];

                // Controleer of het een AJAX-verzoek is
                if (request()->ajax() || request()->wantsJson()) {
                    return response()->json($failData, 500);
                }

                return view('admin.canvas-test', [
                    'testData' => $failData,
                    'success' => false
                ]);
            }
        } catch (\Exception $e) {
            $errorData = [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'logs' => $this->getRecentLogs()
            ];

            // Controleer of het een AJAX-verzoek is
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json($errorData, 500);
            }

            return view('admin.canvas-test', [
                'testData' => $errorData,
                'success' => false
            ]);
        }
    }

    /**
     * Haal de meest recente log entries op
     */
    private function getRecentLogs($limit = 20)
    {
        if (file_exists(storage_path('logs/laravel.log'))) {
            $log = file_get_contents(storage_path('logs/laravel.log'));
            $pattern = '/\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\].*?(?=\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}|$)/s';

            preg_match_all($pattern, $log, $matches);

            $entries = $matches[0];
            $entries = array_slice(array_reverse($entries), 0, $limit);

            return $entries;
        }

        return ['Geen logbestand gevonden'];
    }
}
