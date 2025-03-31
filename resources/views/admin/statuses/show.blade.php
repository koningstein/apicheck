@extends('layouts.layoutadmin')

@section('topmenu')
    <nav class="card">
        <div class="max-w-6xl mx-auto px-2 sm:px-6 lg:px-8">
            <div class="relative flex items-center justify-between h-16">
                <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="sm:block sm:ml-6">
                        <div class="flex space-x-4">
                            <a href="{{ route('admin.statuses.index') }}" class="text-gray-800 px-3 py-2 rounded-md text-sm font-medium" aria-current="page">Overzicht Statussen</a>
                            <a href="{{ route('admin.statuses.create') }}" class="text-gray-800 hover:text-teal-600 transition ease-in-out duration-500 px-3 py-2 rounded-md text-sm font-medium">Status Toevoegen</a>
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
            <h1 class="h6">Status Details</h1>
        </div>
        <div class="py-4 px-6">
            <h2 class="text-sm font-semibold text-gray-800">Status details</h2>
            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-gray-100 rounded-lg p-4">
                    <h3 class="font-medium text-gray-700">Naam</h3>
                    <p class="mt-2 text-gray-600">{{ $status->name }}</p>
                </div>

                <div class="bg-gray-100 rounded-lg p-4">
                    <h3 class="font-medium text-gray-700">Beschrijving</h3>
                    <p class="mt-2 text-gray-600">{{ $status->description ?? 'Geen beschrijving' }}</p>
                </div>
            </div>

            <div class="mt-6 flex space-x-4">
                <a href="{{ route('admin.statuses.edit', ['status' => $status->id]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-edit mr-1"></i> Bewerken
                </a>
                <a href="{{ route('admin.statuses.delete', ['status' => $status->id]) }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-trash-alt mr-1"></i> Verwijderen
                </a>
            </div>
        </div>
    </div>
@endsection
