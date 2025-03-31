<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CohortStoreRequest;
use App\Http\Requests\CohortUpdateRequest;
use App\Models\Cohort;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;
use Throwable;

class CohortController extends Controller
{
    // Permissies koppelen aan de methodes
//    public static function middleware(): array
//    {
//        return [
//            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('index cohort'), only:['index']),
//            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('show cohort'), only:['show']),
//            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('create cohort'), only:['create', 'store']),
//            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('edit cohort'), only:['edit', 'update']),
//            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('delete cohort'), only:['delete', 'destroy']),
//        ];
//    }

    /**
     * Display a listing of the resource.
     * @return View
     */
    public function index(): View
    {
        $cohorts = Cohort::paginate(15);
        return view('admin.cohorts.index', ['cohorts' => $cohorts]);
    }

    /**
     * Show the form for creating a new resource.
     * @return View
     */
    public function create(): View
    {
        return view('admin.cohorts.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  CohortStoreRequest  $request
     * @return RedirectResponse
     */
    public function store(CohortStoreRequest $request): RedirectResponse
    {
        $cohort = new Cohort();
        $cohort->name = $request->name;
        $cohort->startdate = $request->startdate;
        $cohort->enddate = $request->enddate;
        $cohort->save();

        return to_route('admin.cohorts.index')->with('status', "Cohort $cohort->name created successfully.");
    }

    /**
     * Display the specified resource.
     * @param  Cohort  $cohort
     * @return View
     */
    public function show(Cohort $cohort): View
    {
        return view('admin.cohorts.show', ['cohort' => $cohort]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  Cohort  $cohort
     * @return View
     */
    public function edit(Cohort $cohort): View
    {
        return view('admin.cohorts.edit', ['cohort' => $cohort]);
    }

    /**
     * Update the specified resource in storage.
     * @param  CohortUpdateRequest  $request
     * @param  Cohort  $cohort
     * @return RedirectResponse
     */
    public function update(CohortUpdateRequest $request, Cohort $cohort): RedirectResponse
    {
        $cohort->name = $request->name;
        $cohort->startdate = $request->startdate;
        $cohort->enddate = $request->enddate;
        $cohort->save();

        return to_route('admin.cohorts.index')->with('status', "Cohort $cohort->name updated successfully.");
    }

    /**
     * Show the form for deleting the specified resource.
     * @param  Cohort  $cohort
     * @return View
     */
    public function delete(Cohort $cohort): View
    {
        return view('admin.cohorts.delete', ['cohort' => $cohort]);
    }

    /**
     * Remove the specified resource from storage.
     * @param  Cohort  $cohort
     * @return RedirectResponse
     */
    public function destroy(Cohort $cohort): RedirectResponse
    {
        try {
            $cohort->delete();
        } catch (Throwable $error) {
            report($error);
            return to_route('admin.cohorts.index')->with('status-wrong', 'Cohort cannot be deleted because it is being used.');
        }
        return to_route('admin.cohorts.index')->with('status', "Cohort $cohort->name deleted successfully");
    }
}
