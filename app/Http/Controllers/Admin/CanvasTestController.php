<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CanvasService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class CanvasTestController extends Controller
{
    protected $canvasService;

    public function __construct(CanvasService $canvasService)
    {
        $this->canvasService = $canvasService;
    }

    /**
     * Toon de basis test pagina
     */
    public function index(): View
    {
        return view('admin.canvas.test');
    }

    /**
     * Test de Canvas API verbinding
     */
    public function testConnection()
    {
        try {
            $result = $this->canvasService->testConnection();

            return view('admin.canvas.test-connection', [
                'success' => $result['success'],
                'message' => $result['message'],
                'details' => $result
            ]);
        } catch (\Exception $e) {
            Log::error("Exception bij Canvas test: " . $e->getMessage());

            return view('admin.canvas.test-connection', [
                'success' => false,
                'message' => 'Er is een fout opgetreden: ' . $e->getMessage(),
                'details' => ['error' => $e->getMessage()]
            ]);
        }
    }

    /**
     * Test het ophalen van Canvas ID voor een specifieke Eduarte ID
     */
    public function testFindCanvasId(Request $request)
    {
        $eduarteId = $request->input('eduarte_id');

        if (empty($eduarteId)) {
            return view('admin.canvas.find-canvas-id', [
                'result' => null,
                'error' => 'Geen Eduarte ID opgegeven'
            ]);
        }

        try {
            // Gebruik de uitgebreide test functie
            $result = $this->canvasService->testFindCanvasId($eduarteId);

            return view('admin.canvas.find-canvas-id', [
                'result' => $result,
                'error' => null
            ]);
        } catch (\Exception $e) {
            Log::error("Exception bij Canvas ID test: " . $e->getMessage());

            return view('admin.canvas.find-canvas-id', [
                'result' => null,
                'error' => 'Er is een fout opgetreden: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Test een batch van Eduarte ID's om Canvas ID's te vinden
     */
    public function testBatchFindCanvasIds(Request $request)
    {
        $eduarteIds = $request->input('eduarte_ids');

        if (empty($eduarteIds)) {
            return view('admin.canvas.batch-find-canvas-ids', [
                'results' => null,
                'error' => 'Geen Eduarte ID\'s opgegeven'
            ]);
        }

        // Splits de input op komma's of nieuwe regels
        $idArray = preg_split('/[,\r\n]+/', $eduarteIds);
        $idArray = array_map('trim', $idArray);
        $idArray = array_filter($idArray);

        if (empty($idArray)) {
            return view('admin.canvas.batch-find-canvas-ids', [
                'results' => null,
                'error' => 'Geen geldige Eduarte ID\'s gevonden in de input'
            ]);
        }

        try {
            // Beperk tot maximaal 10 ID's om timeouts te voorkomen
            $idArray = array_slice($idArray, 0, 10);

            $results = [];
            $summary = [
                'total' => count($idArray),
                'found' => 0,
                'not_found' => 0,
                'errors' => 0
            ];

            foreach ($idArray as $eduarteId) {
                try {
                    $canvasId = $this->canvasService->getCanvasIdByEduarteId($eduarteId);

                    $results[] = [
                        'eduarte_id' => $eduarteId,
                        'canvas_id' => $canvasId,
                        'found' => !empty($canvasId)
                    ];

                    if (!empty($canvasId)) {
                        $summary['found']++;
                    } else {
                        $summary['not_found']++;
                    }
                } catch (\Exception $e) {
                    $results[] = [
                        'eduarte_id' => $eduarteId,
                        'canvas_id' => null,
                        'found' => false,
                        'error' => $e->getMessage()
                    ];

                    $summary['errors']++;
                }
            }

            return view('admin.canvas.batch-find-canvas-ids', [
                'results' => $results,
                'summary' => $summary,
                'error' => null
            ]);
        } catch (\Exception $e) {
            Log::error("Exception bij Canvas batch ID test: " . $e->getMessage());

            return view('admin.canvas.batch-find-canvas-ids', [
                'results' => null,
                'error' => 'Er is een fout opgetreden: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Toon informatie over de cursussen in Canvas
     */
    public function showCourses()
    {
        try {
            $courses = $this->canvasService->getCourses();

            // Sorteer op aantal studenten (indien beschikbaar)
            usort($courses, function($a, $b) {
                $aCount = $a['total_students'] ?? 0;
                $bCount = $b['total_students'] ?? 0;
                return $bCount - $aCount;
            });

            return view('admin.canvas.courses', [
                'courses' => $courses,
                'total' => count($courses),
                'error' => null
            ]);
        } catch (\Exception $e) {
            Log::error("Exception bij Canvas cursussen tonen: " . $e->getMessage());

            return view('admin.canvas.courses', [
                'courses' => [],
                'total' => 0,
                'error' => 'Er is een fout opgetreden: ' . $e->getMessage()
            ]);
        }
    }
}
