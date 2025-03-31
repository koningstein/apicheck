<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolYearStoreRequest;
use App\Http\Requests\SchoolYearUpdateRequest;
use App\Models\SchoolYear;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Throwable;

class SchoolYearController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return View
     */
    public function index(): View
    {
        $schoolYears = SchoolYear::paginate(15);
        return view('admin.school-years.index', ['schoolYears' => $schoolYears]);
    }

    /**
     * Show the form for creating a new resource.
     * @return View
     */
    public function create(): View
    {
        return view('admin.school-years.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  SchoolYearStoreRequest  $request
     * @return RedirectResponse
     */
    public function store(SchoolYearStoreRequest $request): RedirectResponse
    {
        $schoolYear = new SchoolYear();
        $schoolYear->name = $request->name;
        $schoolYear->startdate = $request->startdate;
        $schoolYear->enddate = $request->enddate;
        $schoolYear->save();

        return to_route('admin.school-years.index')->with('status', "Schooljaar $schoolYear->name created successfully.");
    }

    /**
     * Display the specified resource.
     * @param  SchoolYear  $schoolYear
     * @return View
     */
    public function show(SchoolYear $schoolYear): View
    {
        return view('admin.school-years.show', ['schoolYear' => $schoolYear]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  SchoolYear  $schoolYear
     * @return View
     */
    public function edit(SchoolYear $schoolYear): View
    {
        return view('admin.school-years.edit', ['schoolYear' => $schoolYear]);
    }

    /**
     * Update the specified resource in storage.
     * @param  SchoolYearUpdateRequest  $request
     * @param  SchoolYear  $schoolYear
     * @return RedirectResponse
     */
    public function update(SchoolYearUpdateRequest $request, SchoolYear $schoolYear): RedirectResponse
    {
        $schoolYear->name = $request->name;
        $schoolYear->startdate = $request->startdate;
        $schoolYear->enddate = $request->enddate;
        $schoolYear->save();

        return to_route('admin.school-years.index')->with('status', "Schooljaar $schoolYear->name updated successfully.");
    }

    /**
     * Show the form for deleting the specified resource.
     * @param  SchoolYear  $schoolYear
     * @return View
     */
    public function delete(SchoolYear $schoolYear): View
    {
        return view('admin.school-years.delete', ['schoolYear' => $schoolYear]);
    }

    /**
     * Remove the specified resource from storage.
     * @param  SchoolYear  $schoolYear
     * @return RedirectResponse
     */
    public function destroy(SchoolYear $schoolYear): RedirectResponse
    {
        try {
            $schoolYear->delete();
        } catch (Throwable $error) {
            report($error);
            return to_route('admin.school-years.index')->with('status-wrong', 'Schooljaar cannot be deleted because it is being used.');
        }
        return to_route('admin.school-years.index')->with('status', "Schooljaar $schoolYear->name deleted successfully");
    }
}
