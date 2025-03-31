@extends('layouts.layoutadmin')

@section('topmenu')
    <nav class="card">
        <div class="max-w-6xl mx-auto px-2 sm:px-6 lg:px-8">
            <div class="relative flex items-center justify-between h-16">
                <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="sm:block sm:ml-6">
                        <div class="flex space-x-4">
                            <a href="{{ route('admin.cohorts.index') }}" class="text-gray-800 px-3 py-2 rounded-md text-sm font-medium" aria-current="page">Overzicht Cohorts</a>
                            <a href="{{ route('admin.cohorts.create') }}" class="text-gray-800 hover:text-teal-600 transition ease-in-out duration-500 px-3 py-2 rounded-md text-sm font-medium">Cohort Toevoegen</a>
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
            <h1 class="h6">Cohort Details</h1>
        </div>
        <div class="py-4 px-6">
            <h2 class="text-sm font-semibold text-gray-800">Cohort details</h2>
            <h2 class="text-sm font-semibold text-gray-800">Cohort details</h2>
            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-gray-100 rounded-lg p-4">
                    <h3 class="font-medium text-gray-700">Naam</h3>
                    <p class="mt-2 text-gray-600">{{ $cohort->name }}</p>
                </div>

                <div class="bg-gray-100 rounded-lg p-4">
                    <h3 class="font-medium text-gray-700">Startdatum</h3>
                    <p class="mt-2 text-gray-600">{{ $cohort->startdate ? date('d-m-Y', strtotime($cohort->startdate)) : 'Niet ingesteld' }}</p>
                </div>

                <div class="bg-gray-100 rounded-lg p-4">
                    <h3 class="font-medium text-gray-700">Einddatum</h3>
                    <p class="mt-2 text-gray-600">{{ $cohort->enddate ? date('d-m-Y', strtotime($cohort->enddate)) : 'Niet ingesteld' }}</p>
                </div>

                <div class="bg-gray-100 rounded-lg p-4">
                    <h3 class="font-medium text-gray-700">Duur</h3>
                    <p class="mt-2 text-gray-600">
                        @if($cohort->startdate && $cohort->enddate)
                            @php
                                $start = new DateTime($cohort->startdate);
                                $end = new DateTime($cohort->enddate);
                                $interval = $start->diff($end);
                                echo $interval->y . ' jaar en ' . $interval->m . ' maanden';
                            @endphp
                        @else
                            Niet bepaald
                        @endif
                    </p>
                </div>
            </div>

            <div class="mt-6 flex space-x-4">
                <a href="{{ route('admin.cohorts.edit', ['cohort' => $cohort->id]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-edit mr-1"></i> Bewerken
                </a>
                <a href="{{ route('admin.cohorts.delete', ['cohort' => $cohort->id]) }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-trash-alt mr-1"></i> Verwijderen
                </a>
            </div>
        </div>
    </div>
@endsection
