<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolClassStoreRequest;
use App\Http\Requests\SchoolClassUpdateRequest;
use App\Models\SchoolClass;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Throwable;

class SchoolClassController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return View
     */
    public function index(): View
    {
        $schoolClasses = SchoolClass::paginate(15);
        return view('admin.school-classes.index', ['schoolClasses' => $schoolClasses]);
    }

    /**
     * Show the form for creating a new resource.
     * @return View
     */
    public function create(): View
    {
        return view('admin.school-classes.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  SchoolClassStoreRequest  $request
     * @return RedirectResponse
     */
    public function store(SchoolClassStoreRequest $request): RedirectResponse
    {
        $schoolClass = new SchoolClass();
        $schoolClass->name = $request->name;
        $schoolClass->description = $request->description;
        $schoolClass->save();

        return to_route('admin.school-classes.index')->with('status', "Klas $schoolClass->name met succes aangemaakt.");
    }

    /**
     * Display the specified resource.
     * @param  SchoolClass  $schoolClass
     * @return View
     */
    public function show(SchoolClass $schoolClass): View
    {
        return view('admin.school-classes.show', ['schoolClass' => $schoolClass]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  SchoolClass  $schoolClass
     * @return View
     */
    public function edit(SchoolClass $schoolClass): View
    {
        return view('admin.school-classes.edit', ['schoolClass' => $schoolClass]);
    }

    /**
     * Update the specified resource in storage.
     * @param  SchoolClassUpdateRequest  $request
     * @param  SchoolClass  $schoolClass
     * @return RedirectResponse
     */
    public function update(SchoolClassUpdateRequest $request, SchoolClass $schoolClass): RedirectResponse
    {
        $schoolClass->name = $request->name;
        $schoolClass->description = $request->description;
        $schoolClass->save();

        return to_route('admin.school-classes.index')->with('status', "Klas $schoolClass->name met succes bijgewerkt.");
    }

    /**
     * Show the form for deleting the specified resource.
     * @param  SchoolClass  $schoolClass
     * @return View
     */
    public function delete(SchoolClass $schoolClass): View
    {
        return view('admin.school-classes.delete', ['schoolClass' => $schoolClass]);
    }

    /**
     * Remove the specified resource from storage.
     * @param  SchoolClass  $schoolClass
     * @return RedirectResponse
     */
    public function destroy(SchoolClass $schoolClass): RedirectResponse
    {
        try {
            $schoolClass->delete();
        } catch (Throwable $error) {
            report($error);
            return to_route('admin.school-classes.index')->with('status-wrong', 'Klas kan niet worden verwijderd omdat deze in gebruik is.');
        }
        return to_route('admin.school-classes.index')->with('status', "Klas $schoolClass->name met succes verwijderd");
    }
}
