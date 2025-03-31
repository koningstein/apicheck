@extends('layouts.layoutadmin')

@section('topmenu')
    <nav class="card">
        <div class="max-w-6xl mx-auto px-2 sm:px-6 lg:px-8">
            <div class="relative flex items-center justify-between h-16">
                <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="sm:block sm:ml-6">
                        <div class="flex space-x-4">
                            <a href="{{ route('admin.crebos.index') }}" class="text-gray-800 px-3 py-2 rounded-md text-sm font-medium" aria-current="page">Overzicht Crebos</a>
                            <a href="{{ route('admin.crebos.create') }}" class="text-gray-800 hover:text-teal-600 transition ease-in-out duration-500 px-3 py-2 rounded-md text-sm font-medium">Crebo Toevoegen</a>
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
            <h1 class="h6">Crebo Details</h1>
        </div>

        <div class="py-4 px-6">
            <h2 class="text-sm font-semibold text-gray-800">Crebo details</h2>
            <p class="py-2 text-sm text-gray-700">Naam:  {{ $crebo->name }}</p>
            <p class="py-2 text-sm text-gray-700">Crebo nr:  {{ $crebo->crebonr }}</p>
            <p class="py-2 text-sm text-gray-700">Omschrijving: <br> {!! nl2br(e($crebo->description)) !!}</p>
        </div>
    </div>
@endsection
