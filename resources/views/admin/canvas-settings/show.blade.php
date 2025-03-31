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
            <h1 class="h6">Canvas API Instelling Details</h1>
        </div>
        <div class="py-4 px-6">
            <h2 class="text-sm font-semibold text-gray-800">Canvas API details</h2>
            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-gray-100 rounded-lg p-4">
                    <h3 class="font-medium text-gray-700">API URL</h3>
                    <p class="mt-2 text-gray-600">{{ $setting->apiurl }}</p>
                </div>

                <div class="bg-gray-100 rounded-lg p-4">
                    <h3 class="font-medium text-gray-700">API Token</h3>
                    <p class="mt-2 text-gray-600">
                        <span class="bg-gray-200 px-2 py-1 rounded">{{ substr($setting->apitoken, 0, 5) . '••••••••••••••••••' . substr($setting->apitoken, -5) }}</span>
                    </p>
                </div>

                <div class="bg-gray-100 rounded-lg p-4">
                    <h3 class="font-medium text-gray-700">Status</h3>
                    <p class="mt-2">
                        <span class="px-2 py-1 rounded text-white text-xs {{ $setting->active ? 'bg-green-500' : 'bg-red-500' }}">
                            {{ $setting->active ? 'Actief' : 'Inactief' }}
                        </span>
                    </p>
                </div>

                <div class="bg-gray-100 rounded-lg p-4">
                    <h3 class="font-medium text-gray-700">Laatst bijgewerkt</h3>
                    <p class="mt-2 text-gray-600">
                        {{ $setting->updated_at ? date('d-m-Y H:i', strtotime($setting->updated_at)) : 'Nooit' }}
                    </p>
                </div>
            </div>

            <div class="mt-6 flex space-x-4">
                <a href="{{ route('admin.canvas-settings.edit', ['canvas_setting' => $setting->id]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-edit mr-1"></i> Bewerken
                </a>
                <a href="{{ route('admin.canvas-settings.delete', ['canvas_setting' => $setting->id]) }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-trash-alt mr-1"></i> Verwijderen
                </a>
            </div>
        </div>
    </div>
@endsection
