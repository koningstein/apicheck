<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreboStoreRequest;
use App\Http\Requests\CreboUpdateRequest;
use App\Models\Crebo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;
use Throwable;

class CreboController extends Controller
{
//    public static function middleware(): array
//    {
//        return [
//            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::class . ':index crebo', only: ['index']),
//            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::class . ':show crebo', only: ['show']),
//            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::class . ':create crebo', only: ['create', 'store']),
//            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::class . ':edit crebo', only: ['edit', 'update']),
//            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::class . ':delete crebo', only: ['delete', 'destroy']),
//        ];
//    }

    public function index(): View
    {
        $crebos = Crebo::paginate(15);
        //dd($crebos);
        return view('admin.crebos.index', compact('crebos'));
    }

    public function create(): View
    {
        return view('admin.crebos.create');
    }

    public function store(CreboStoreRequest $request): RedirectResponse
    {
        $crebo = new Crebo();
        $crebo->name = $request->name;
        $crebo->crebonr = $request->crebonr;
        $crebo->save();

        return redirect()->route('admin.crebos.index')->with('status', "Crebo $crebo->name created successfully.");
    }

    public function show(Crebo $crebo): View
    {
        return view('admin.crebos.show', compact('crebo'));
    }

    public function edit(Crebo $crebo): View
    {
        return view('admin.crebos.edit', compact('crebo'));
    }

    public function update(CreboUpdateRequest $request, Crebo $crebo): RedirectResponse
    {
        $crebo->name = $request->name;
        $crebo->crebonr = $request->crebonr;
        $crebo->save();

        return redirect()->route('admin.crebos.index')->with('status', "Crebo $crebo->name updated successfully.");
    }

    public function delete(Crebo $crebo): View
    {
        return view('admin.crebos.delete', compact('crebo'));
    }

    public function destroy(Crebo $crebo): RedirectResponse
    {
        try {
            $crebo->delete();
        } catch (Throwable $error) {
            report($error);
            return to_route('admin.crebos.index')->with('status-wrong', 'Crebo cannot be deleted because it is being used.');
        }
        return to_route('admin.crebos.index')->with('status', "Crebo $crebo->crebonr deleted successfully");
    }
}
