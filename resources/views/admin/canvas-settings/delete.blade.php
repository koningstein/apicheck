@extends('layouts.layoutadmin')

@section('topmenu')
    <nav class="card">
        <div class="max-w-6xl mx-auto px-2 sm:px-6 lg:px-8">
            <div class="relative flex items-center justify-between h-16">
                <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="sm:block sm:ml-6">
                        <div class="flex space-x-4">
                            <a href="{{ route('admin.canvas-settings.index') }}" class="text-gray-800 px-3 py-2 rounded-md text-sm font-medium" aria-current="page">Overzicht Canvas Instellingen</a>
                            <a href="{{ route('admin.canvas-settings.create') }}" class="text-gray-800 hover:text-teal-600 transition ease-in-out duration-500 px-3 py-2 rounded-md text-sm font-medium">Canvas Instelling Toevoegen</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
@endsection

@section('content')
    <div class="card mt-6">
        <div class="card-header flex flex-row justify-between">
            <h1 class="h6">Canvas API Instelling Verwijderen</h1>
        </div>

        @if($errors->any())
            <div class="bg-red-200 text-red-900 rounded-lg shadow-md p-6 pr-10 mb-8"
                 style="min-width: 240px">
                <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card-body grid grid-cols-1 gap-6 lg:grid-cols-1">
            <div class="p-4">
                <form id="form" class="shadow-md rounded-lg px-8 pt-6 pb-8 mb-4"
                      action="{{ route('admin.canvas-settings.destroy', ['canvas_setting' => $setting->id]) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm">
                            <span class="text-gray-700">Canvas API URL</span>
                            <input class="bg-gray-200 block rounded w-full p-2 mt-1 focus:border-purple-400
                            focus:outline-none focus:shadow-outline-purple form-input"
                                   name="apiurl" value="{{ $setting->apiurl }}" type="url" disabled/>
                        </label>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm">
                            <span class="text-gray-700">Canvas API Token</span>
                            <input class="bg-gray-200 block rounded w-full p-2 mt-1 focus:border-purple-400
                            focus:outline-none focus:shadow-outline-purple form-input"
                                   name="apitoken" value="{{ substr($setting->apitoken, 0, 5) . '••••••••••••••••••' . substr($setting->apitoken, -5) }}" type="text" disabled/>
                        </label>
                    </div>

                    <div class="mb-4 flex items-center">
                        <label class="flex items-center text-sm">
                            <input type="checkbox" class="form-checkbox text-purple-600"
                                   {{ $setting->active ? 'checked' : '' }} disabled>
                            <span class="ml-2 text-gray-700">Actief</span>
                        </label>
                    </div>

                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                        <p class="font-bold">Let op!</p>
                        <p>Weet je zeker dat je deze Canvas API instelling wilt verwijderen? Deze actie kan niet ongedaan worden gemaakt.</p>
                        <p>Als deze instelling actief is en in gebruik is door het systeem, kan dit leiden tot problemen met de Canvas integratie.</p>
                    </div>
                    <button class="mt-2 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150
                    bg-red-600 border border-transparent rounded-lg active:bg-red-600 hover:bg-red-700
                    focus:outline-none focus:shadow-outline-red">Verwijderen</button>
                </form>
            </div>
        </div>
    </div>
@endsection
