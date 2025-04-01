<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EnrollmentStoreRequest;
use App\Http\Requests\EnrollmentUpdateRequest;
use App\Models\Cohort;
use App\Models\Crebo;
use App\Models\Enrollment;
use App\Models\Status;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Throwable;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return View
     */
    public function index(): View
    {
        $enrollments = Enrollment::with(['student', 'crebo', 'cohort', 'status'])->paginate(15);
        return view('admin.enrollments.index', compact('enrollments'));
    }

    /**
     * Show the form for creating a new resource.
     * @return View
     */
    public function create(): View
    {
        $students = Student::where('isactive', true)->orderBy('eduarteid')->get();
        $crebos = Crebo::orderBy('name')->get();
        $cohorts = Cohort::orderBy('name')->get();
        $statuses = Status::orderBy('name')->get();

        return view('admin.enrollments.create', compact('students', 'crebos', 'cohorts', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     * @param EnrollmentStoreRequest $request
     * @return RedirectResponse
     */
    public function store(EnrollmentStoreRequest $request): RedirectResponse
    {
        $enrollment = new Enrollment();
        $enrollment->student_id = $request->student_id;
        $enrollment->crebo_id = $request->crebo_id;
        $enrollment->cohort_id = $request->cohort_id;
        $enrollment->status_id = $request->status_id;
        $enrollment->enrollmentdate = $request->enrollmentdate;
        $enrollment->enddate = $request->enddate;
        $enrollment->save();

        return to_route('admin.enrollments.index')->with('status', "Inschrijving voor student succesvol aangemaakt.");
    }

    /**
     * Display the specified resource.
     * @param Enrollment $enrollment
     * @return View
     */
    public function show(Enrollment $enrollment): View
    {
        $enrollment->load(['student', 'crebo', 'cohort', 'status', 'enrollmentClasses.classYear.schoolClass', 'enrollmentClasses.classYear.schoolYear']);
        return view('admin.enrollments.show', compact('enrollment'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param Enrollment $enrollment
     * @return View
     */
    public function edit(Enrollment $enrollment): View
    {
        $students = Student::where('isactive', true)->orderBy('eduarteid')->get();
        $crebos = Crebo::orderBy('name')->get();
        $cohorts = Cohort::orderBy('name')->get();
        $statuses = Status::orderBy('name')->get();

        return view('admin.enrollments.edit', compact('enrollment', 'students', 'crebos', 'cohorts', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     * @param EnrollmentUpdateRequest $request
     * @param Enrollment $enrollment
     * @return RedirectResponse
     */
    public function update(EnrollmentUpdateRequest $request, Enrollment $enrollment): RedirectResponse
    {
        $enrollment->student_id = $request->student_id;
        $enrollment->crebo_id = $request->crebo_id;
        $enrollment->cohort_id = $request->cohort_id;
        $enrollment->status_id = $request->status_id;
        $enrollment->enrollmentdate = $request->enrollmentdate;
        $enrollment->enddate = $request->enddate;
        $enrollment->save();

        return to_route('admin.enrollments.index')->with('status', "Inschrijving succesvol bijgewerkt.");
    }

    /**
     * Show the form for deleting the specified resource.
     * @param Enrollment $enrollment
     * @return View
     */
    public function delete(Enrollment $enrollment): View
    {
        $enrollment->load(['student', 'crebo', 'cohort', 'status']);
        return view('admin.enrollments.delete', compact('enrollment'));
    }

    /**
     * Remove the specified resource from storage.
     * @param Enrollment $enrollment
     * @return RedirectResponse
     */
    public function destroy(Enrollment $enrollment): RedirectResponse
    {
        try {
            $studentName = $enrollment->student->eduarteid;
            $enrollment->delete();
        } catch (Throwable $error) {
            report($error);
            return to_route('admin.enrollments.index')->with('status-wrong', 'Inschrijving kan niet worden verwijderd omdat deze in gebruik is.');
        }

        return to_route('admin.enrollments.index')->with('status', "Inschrijving voor student $studentName succesvol verwijderd.");
    }
}
