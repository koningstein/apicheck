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
     * Deze methode gebruikt een aanroep die werkt met beperkte rechten
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
     */
    public function getCourses()
    {
        try {
            $response = Http::withOptions([
                'verify' => false, // Belangrijk: SSL-verificatie uitschakelen
            ])->withHeaders([
                'Authorization' => 'Bearer ' . $this->apiToken,
            ])->get($this->apiUrl . '/api/v1/courses', [
                'per_page' => 100 // Aantal resultaten per pagina
            ]);

            if ($response->failed()) {
                Log::error('API-aanroep mislukt: ' . $response->body());
                return null;
            }
            Log::info('API-aanroep Gelukt: Cursussen opgehaald.');
            return $response->json();
        } catch (\Exception $e) {
            Log::error('Exception bij het ophalen van cursussen: ' . $e->getMessage());
            return null;
        }
    }
}
