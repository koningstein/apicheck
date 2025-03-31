@extends('layouts.layoutadmin')

@section('topmenu')
    <nav class="card">
        <div class="max-w-6xl mx-auto px-2 sm:px-6 lg:px-8">
            <div class="relative flex items-center justify-between h-16">
                <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="sm:block sm:ml-6">
                        <div class="flex space-x-4">
                            <a href="{{ route('admin.students.index') }}" class="text-gray-800 px-3 py-2 rounded-md text-sm font-medium" aria-current="page">Overzicht Studenten</a>
                            <a href="{{ route('admin.students.create') }}" class="text-gray-800 hover:text-teal-600 transition ease-in-out duration-500 px-3 py-2 rounded-md text-sm font-medium">Student Toevoegen</a>
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
            <h1 class="h6">Student Details</h1>
        </div>
        <div class="py-4 px-6">
            <h2 class="text-sm font-semibold text-gray-800">Student gegevens</h2>
            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-gray-100 rounded-lg p-4">
                    <h3 class="font-medium text-gray-700">Eduarte ID</h3>
                    <p class="mt-2 text-gray-600">{{ $student->eduarteid }}</p>
                </div>

                <div class="bg-gray-100 rounded-lg p-4">
                    <h3 class="font-medium text-gray-700">Canvas ID</h3>
                    <p class="mt-2 text-gray-600">{{ $student->canvasid ?? 'Niet ingesteld' }}</p>
                </div>

                <div class="bg-gray-100 rounded-lg p-4">
                    <h3 class="font-medium text-gray-700">Status</h3>
                    <p class="mt-2 text-gray-600">
                        <span class="px-2 py-1 rounded {{ $student->isactive ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                            {{ $student->isactive ? 'Actief' : 'Inactief' }}
                        </span>
                    </p>
                </div>
            </div>

            @if($student->enrollments->count() > 0)
                <h2 class="text-sm font-semibold text-gray-800 mt-8">Inschrijvingen</h2>
                <div class="mt-4 overflow-x-auto rounded-lg">
                    <table class="min-w-full bg-white">
                        <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Crebo</th>
                            <th class="py-3 px-6 text-left">Cohort</th>
                            <th class="py-3 px-6 text-left">Status</th>
                            <th class="py-3 px-6 text-left">Inschrijfdatum</th>
                            <th class="py-3 px-6 text-left">Einddatum</th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm">
                        @foreach($student->enrollments as $enrollment)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left">
                                    {{ $enrollment->crebo->name ?? 'Onbekend' }} ({{ $enrollment->crebo->code ?? 'N/A' }})
                                </td>
                                <td class="py-3 px-6 text-left">
                                    {{ $enrollment->cohort->name ?? 'Onbekend' }}
                                </td>
                                <td class="py-3 px-6 text-left">
                                        <span class="px-2 py-1 rounded
                                            {{ $enrollment->status->name === 'Actief' ? 'bg-green-200 text-green-800' :
                                               ($enrollment->status->name === 'Gestopt' ? 'bg-red-200 text-red-800' :
                                               'bg-blue-200 text-blue-800') }}">
                                            {{ $enrollment->status->name ?? 'Onbekend' }}
                                        </span>
                                </td>
                                <td class="py-3 px-6 text-left">
                                    {{ $enrollment->enrollmentdate ? date('d-m-Y', strtotime($enrollment->enrollmentdate)) : 'Niet ingesteld' }}
                                </td>
                                <td class="py-3 px-6 text-left">
                                    {{ $enrollment->enddate ? date('d-m-Y', strtotime($enrollment->enddate)) : 'Niet ingesteld' }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="mt-8 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
                    <p class="font-bold">Let op!</p>
                    <p>Deze student heeft nog geen inschrijvingen.</p>
                </div>
            @endif

            <div class="mt-6 flex space-x-4">
                <a href="{{ route('admin.students.edit', ['student' => $student->id]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-edit mr-1"></i> Bewerken
                </a>
                <a href="{{ route('admin.students.delete', ['student' => $student->id]) }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-trash-alt mr-1"></i> Verwijderen
                </a>
            </div>
        </div>
    </div>
@endsection
