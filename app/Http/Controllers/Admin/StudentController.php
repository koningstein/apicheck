<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentStoreRequest;
use App\Http\Requests\StudentUpdateRequest;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Throwable;

class StudentController extends Controller
{
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
        $student->canvasid = $request->canvasid;
        $student->isactive = $request->has('isactive');
        $student->save();

        return to_route('admin.students.index')->with('status', "Student met ID $student->eduarteid is aangemaakt.");
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
        $student->canvasid = $request->canvasid;
        $student->isactive = $request->has('isactive');
        $student->save();

        return to_route('admin.students.index')->with('status', "Student met ID $student->eduarteid is bijgewerkt.");
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
}
