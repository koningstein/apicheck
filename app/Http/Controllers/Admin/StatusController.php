<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StatusStoreRequest;
use App\Http\Requests\StatusUpdateRequest;
use App\Models\Status;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Throwable;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return View
     */
    public function index(): View
    {
        $statuses = Status::paginate(15);
        return view('admin.statuses.index', ['statuses' => $statuses]);
    }

    /**
     * Show the form for creating a new resource.
     * @return View
     */
    public function create(): View
    {
        return view('admin.statuses.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  StatusStoreRequest  $request
     * @return RedirectResponse
     */
    public function store(StatusStoreRequest $request): RedirectResponse
    {
        $status = new Status();
        $status->name = $request->name;
        $status->description = $request->description;
        $status->save();

        return to_route('admin.statuses.index')->with('status', "Status '$status->name' is aangemaakt.");
    }

    /**
     * Display the specified resource.
     * @param  Status  $status
     * @return View
     */
    public function show(Status $status): View
    {
        return view('admin.statuses.show', ['status' => $status]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  Status  $status
     * @return View
     */
    public function edit(Status $status): View
    {
        return view('admin.statuses.edit', ['status' => $status]);
    }

    /**
     * Update the specified resource in storage.
     * @param  StatusUpdateRequest  $request
     * @param  Status  $status
     * @return RedirectResponse
     */
    public function update(StatusUpdateRequest $request, Status $status): RedirectResponse
    {
        $status->name = $request->name;
        $status->description = $request->description;
        $status->save();

        return to_route('admin.statuses.index')->with('status', "Status '$status->name' is bijgewerkt.");
    }

    /**
     * Show the form for deleting the specified resource.
     * @param  Status  $status
     * @return View
     */
    public function delete(Status $status): View
    {
        return view('admin.statuses.delete', ['status' => $status]);
    }

    /**
     * Remove the specified resource from storage.
     * @param  Status  $status
     * @return RedirectResponse
     */
    public function destroy(Status $status): RedirectResponse
    {
        try {
            $status->delete();
        } catch (Throwable $error) {
            report($error);
            return to_route('admin.statuses.index')->with('status-wrong', 'Status kan niet worden verwijderd omdat deze in gebruik is.');
        }
        return to_route('admin.statuses.index')->with('status', "Status '$status->name' is verwijderd");
    }
}
