<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CanvasSettingStoreRequest;
use App\Http\Requests\CanvasSettingUpdateRequest;
use App\Models\CanvasSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Throwable;

class CanvasSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return View
     */
    public function index(): View
    {
        $settings = CanvasSetting::paginate(15);
        return view('admin.canvas-settings.index', ['settings' => $settings]);
    }

    /**
     * Show the form for creating a new resource.
     * @return View
     */
    public function create(): View
    {
        return view('admin.canvas-settings.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  CanvasSettingStoreRequest  $request
     * @return RedirectResponse
     */
    public function store(CanvasSettingStoreRequest $request): RedirectResponse
    {
        $setting = new CanvasSetting();
        $setting->apiurl = $request->apiurl;
        $setting->apitoken = $request->apitoken;
        $setting->active = $request->has('active');
        $setting->save();

        return to_route('admin.canvas-settings.index')->with('status', "Canvas API instellingen succesvol aangemaakt.");
    }

    /**
     * Display the specified resource.
     * @param  CanvasSetting  $canvas_setting
     * @return View
     */
    public function show(CanvasSetting $canvas_setting): View
    {
        return view('admin.canvas-settings.show', ['setting' => $canvas_setting]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  CanvasSetting  $canvasSetting
     * @return View
     */
    public function edit(CanvasSetting $canvasSetting): View
    {
        return view('admin.canvas-settings.edit', ['setting' => $canvasSetting]);
    }

    /**
     * Update the specified resource in storage.
     * @param  CanvasSettingUpdateRequest  $request
     * @param  CanvasSetting  $canvasSetting
     * @return RedirectResponse
     */
    public function update(CanvasSettingUpdateRequest $request, CanvasSetting $canvasSetting): RedirectResponse
    {
        $canvasSetting->apiurl = $request->apiurl;

        // Only update the token if it's not empty (preserves existing token if not changed)
        if (!empty($request->apitoken)) {
            $canvasSetting->apitoken = $request->apitoken;
        }

//        $canvasSetting->active = $request->has('active');
        $canvasSetting->active = (bool) $request->input('active');
        $canvasSetting->save();

        return to_route('admin.canvas-settings.index')->with('status', "Canvas API instellingen succesvol bijgewerkt.");
    }

    /**
     * Show the form for deleting the specified resource.
     * @param  CanvasSetting  $canvasSetting
     * @return View
     */
    public function delete(CanvasSetting $canvasSetting): View
    {
        return view('admin.canvas-settings.delete', ['setting' => $canvasSetting]);
    }

    /**
     * Remove the specified resource from storage.
     * @param  CanvasSetting  $canvasSetting
     * @return RedirectResponse
     */
    public function destroy(CanvasSetting $canvasSetting): RedirectResponse
    {
        try {
            $canvasSetting->delete();
        } catch (Throwable $error) {
            report($error);
            return to_route('admin.canvas-settings.index')->with('status-wrong', 'Canvas instellingen kunnen niet worden verwijderd omdat ze in gebruik zijn.');
        }
        return to_route('admin.canvas-settings.index')->with('status', "Canvas instellingen succesvol verwijderd");
    }
}
