<?php

namespace App\Http\Controllers;

use App\Services\CanvasService;
use Illuminate\Http\Request;

class CanvasController extends Controller
{
    protected CanvasService $canvasService;

    public function __construct(CanvasService $canvasService)
    {
        $this->canvasService = $canvasService;
    }

    public function testConnection()
    {
        $result = $this->canvasService->testConnection();

        if ($result['success']) {
            return view('admin.canvas.test-connection', [
                'status' => 'success',
                'message' => $result['message'],
                'courses_count' => $result['courses_count'],
                'first_course' => $result['first_course']
            ]);
        } else {
            return view('admin.canvas.test-connection', [
                'status' => 'error',
                'message' => $result['message'],
                'error' => $result['error'] ?? 'Onbekende fout'
            ]);
        }
    }

    public function listCourses()
    {
        $courses = $this->canvasService->getCourses();

        if (!$courses) {
            return view('admin.canvas.courses', [
                'status' => 'error',
                'message' => 'Kon geen cursussen ophalen'
            ]);
        }

        return view('admin.canvas.courses', [
            'status' => 'success',
            'courses' => $courses
        ]);
    }
}
