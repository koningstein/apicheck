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
            <h1 class="h6">Inschrijving Wijzigen</h1>
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
                      action="{{ route('admin.enrollments.update', ['enrollment' => $enrollment->id]) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm">
                            <span class="text-gray-700">Student</span>
                            <select class="bg-gray-200 block rounded w-full p-2 mt-1 focus:border-purple-400
                            focus:outline-none focus:shadow-outline-purple form-select"
                                    name="student_id" required>
                                <option value="">-- Selecteer Student --</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ old('student_id', $enrollment->student_id) == $student->id ? 'selected' : '' }}>
                                        {{ $student->eduarteid }} {{ $student->canvasid ? "- Canvas: " . $student->canvasid : "" }}
                                    </option>
                                @endforeach
                            </select>
                        </label>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm">
                            <span class="text-gray-700">Crebo</span>
                            <select class="bg-gray-200 block rounded w-full p-2 mt-1 focus:border-purple-400
                            focus:outline-none focus:shadow-outline-purple form-select"
                                    name="crebo_id" required>
                                <option value="">-- Selecteer Crebo --</option>
                                @foreach($crebos as $crebo)
                                    <option value="{{ $crebo->id }}" {{ old('crebo_id', $enrollment->crebo_id) == $crebo->id ? 'selected' : '' }}>
                                        {{ $crebo->name }} ({{ $crebo->crebonr }})
                                    </option>
                                @endforeach
                            </select>
                        </label>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm">
                            <span class="text-gray-700">Cohort</span>
                            <select class="bg-gray-200 block rounded w-full p-2 mt-1 focus:border-purple-400
                            focus:outline-none focus:shadow-outline-purple form-select"
                                    name="cohort_id" required>
                                <option value="">-- Selecteer Cohort --</option>
                                @foreach($cohorts as $cohort)
                                    <option value="{{ $cohort->id }}" {{ old('cohort_id', $enrollment->cohort_id) == $cohort->id ? 'selected' : '' }}>
                                        {{ $cohort->name }}
                                    </option>
                                @endforeach
                            </select>
                        </label>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm">
                            <span class="text-gray-700">Status</span>
                            <select class="bg-gray-200 block rounded w-full p-2 mt-1 focus:border-purple-400
                            focus:outline-none focus:shadow-outline-purple form-select"
                                    name="status_id" required>
                                <option value="">-- Selecteer Status --</option>
                                @foreach($statuses as $status)
                                    <option value="{{ $status->id }}" {{ old('status_id', $enrollment->status_id) == $status->id ? 'selected' : '' }}>
                                        {{ $status->name }}
                                    </option>
                                @endforeach
                            </select>
                        </label>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm">
                            <span class="text-gray-700">Inschrijfdatum</span>
                            <input class="bg-gray-200 block rounded w-full p-2 mt-1 focus:border-purple-400
                            focus:outline-none focus:shadow-outline-purple form-input"
                                   name="enrollmentdate" value="{{ old('enrollmentdate', $enrollment->enrollmentdate ? date('Y-m-d', strtotime($enrollment->enrollmentdate)) : '') }}" type="date" required/>
                        </label>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm">
                            <span class="text-gray-700">Einddatum</span>
                            <input class="bg-gray-200 block rounded w-full p-2 mt-1 focus:border-purple-400
                            focus:outline-none focus:shadow-outline-purple form-input"
                                   name="enddate" value="{{ old('enddate', $enrollment->enddate ? date('Y-m-d', strtotime($enrollment->enddate)) : '') }}" type="date"/>
                        </label>
                        <p class="text-xs text-gray-500 mt-1">Laat leeg als de einddatum nog niet bekend is</p>
                    </div>
                    <button class="mt-2 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150
                    bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700
                    focus:outline-none focus:shadow-outline-purple">Wijzigen</button>
                </form>
            </div>
        </div>
    </div>
@endsection
