@extends('layouts.layoutadmin')

@section('topmenu')
    <nav class="card">
        <div class="max-w-6xl mx-auto px-2 sm:px-6 lg:px-8">
            <div class="relative flex items-center justify-between h-16">
                <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="sm:block sm:ml-6">
                        <div class="flex space-x-4">
                            <a href="{{ route('admin.enrollments.index') }}" class="text-gray-800 px-3 py-2 rounded-md text-sm font-medium" aria-current="page">Overzicht Inschrijvingen</a>
                            <a href="{{ route('admin.enrollments.create') }}" class="text-gray-800 hover:text-teal-600 transition ease-in-out duration-500 px-3 py-2 rounded-md text-sm font-medium">Inschrijving Toevoegen</a>
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
            <h1 class="h6">Inschrijving Details</h1>
        </div>
        <div class="py-4 px-6">
            <h2 class="text-sm font-semibold text-gray-800">Inschrijving details</h2>
            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-gray-100 rounded-lg p-4">
                    <h3 class="font-medium text-gray-700">Student</h3>
                    <p class="mt-2 text-gray-600">{{ $enrollment->student->eduarteid }}</p>
                    @if($enrollment->student->canvasid)
                        <p class="text-gray-500">Canvas ID: {{ $enrollment->student->canvasid }}</p>
                    @endif
                </div>

                <div class="bg-gray-100 rounded-lg p-4">
                    <h3 class="font-medium text-gray-700">Crebo</h3>
                    <p class="mt-2 text-gray-600">{{ $enrollment->crebo->name }} ({{ $enrollment->crebo->crebonr }})</p>
                </div>

                <div class="bg-gray-100 rounded-lg p-4">
                    <h3 class="font-medium text-gray-700">Cohort</h3>
                    <p class="mt-2 text-gray-600">{{ $enrollment->cohort->name }}</p>
                </div>

                <div class="bg-gray-100 rounded-lg p-4">
                    <h3 class="font-medium text-gray-700">Status</h3>
                    <p class="mt-2 text-gray-600">{{ $enrollment->status->name }}</p>
                </div>

                <div class="bg-gray-100 rounded-lg p-4">
                    <h3 class="font-medium text-gray-700">Inschrijfdatum</h3>
                    <p class="mt-2 text-gray-600">{{ $enrollment->enrollmentdate ? date('d-m-Y', strtotime($enrollment->enrollmentdate)) : 'Niet ingesteld' }}</p>
                </div>

                <div class="bg-gray-100 rounded-lg p-4">
                    <h3 class="font-medium text-gray-700">Einddatum</h3>
                    <p class="mt-2 text-gray-600">{{ $enrollment->enddate ? date('d-m-Y', strtotime($enrollment->enddate)) : 'Niet ingesteld' }}</p>
                </div>
            </div>

            @if($enrollment->enrollmentClasses->count() > 0)
                <h2 class="text-sm font-semibold text-gray-800 mt-6">Klassenindeling</h2>
                <div class="mt-4 overflow-x-auto">
                    <table class="min-w-full border border-gray-300 divide-y divide-gray-300">
                        <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Klas</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Schooljaar</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-300">
                        @foreach($enrollment->enrollmentClasses as $enrollmentClass)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 text-sm text-gray-600">{{ $enrollmentClass->classYear->schoolClass->name }}</td>
                                <td class="px-4 py-2 text-sm text-gray-600">{{ $enrollmentClass->classYear->schoolYear->name }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <div class="mt-6 flex space-x-4">
                <a href="{{ route('admin.enrollments.edit', ['enrollment' => $enrollment->id]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-edit mr-1"></i> Bewerken
                </a>
                <a href="{{ route('admin.enrollments.delete', ['enrollment' => $enrollment->id]) }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-trash-alt mr-1"></i> Verwijderen
                </a>
            </div>
        </div>
    </div>
@endsection
