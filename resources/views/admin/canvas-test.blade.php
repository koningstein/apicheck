@extends('layouts.layoutadmin')

@section('content')
    <div class="card mt-6">
        <div class="card-header flex flex-row justify-between">
            <h1 class="h6">Canvas API Test Resultaten</h1>
        </div>

        <div class="card-body">
            <div class="mb-6 p-4 {{ $success ? 'bg-green-100 border border-green-400 text-green-700' : 'bg-red-100 border border-red-400 text-red-700' }} rounded relative">
                <div class="font-bold mb-2">
                    {{ $success ? 'Verbinding succesvol' : 'Verbinding mislukt' }}
                </div>

                @if(isset($testData['api_connection']))
                    <div class="mb-4">
                        <h2 class="font-semibold mb-1">API Verbinding</h2>
                        <div class="ml-4">
                            <p>Status: {{ $testData['api_connection']['success'] ? 'Succesvol' : 'Mislukt' }}</p>
                            <p>Bericht: {{ $testData['api_connection']['message'] }}</p>

                            @if(isset($testData['api_connection']['courses_count']))
                                <p>Aantal cursussen: {{ $testData['api_connection']['courses_count'] }}</p>
                            @endif

                            @if(isset($testData['api_connection']['first_course']))
                                <p>Eerste cursus: {{ $testData['api_connection']['first_course'] }}</p>
                            @endif

                            @if(isset($testData['api_connection']['error']))
                                <pre class="bg-red-50 p-2 mt-2 rounded text-xs overflow-auto">{{ $testData['api_connection']['error'] }}</pre>
                            @endif
                        </div>
                    </div>
                @endif

                @if(isset($testData['student_test']))
                    <div class="mb-4">
                        <h2 class="font-semibold mb-1">Student API Test</h2>
                        <div class="ml-4">
                            <p>Eduarte ID: {{ $testData['student_test']['eduarte_id'] }}</p>

                            <div class="mt-2">
                                <h3 class="font-medium">Standaard methode:</h3>
                                @if($testData['student_test']['standard_method']['canvas_id_found'])
                                    <p class="text-green-600">Canvas ID gevonden: {{ $testData['student_test']['standard_method']['canvas_id'] }}</p>
                                @else
                                    <p class="text-red-600">Geen Canvas ID gevonden</p>
                                @endif
                            </div>

                            <div class="mt-2">
                                <h3 class="font-medium">Directe methode:</h3>
                                @if($testData['student_test']['direct_method']['canvas_id_found'])
                                    <p class="text-green-600">Canvas ID gevonden: {{ $testData['student_test']['direct_method']['canvas_id'] }}</p>
                                @else
                                    <p class="text-red-600">Geen Canvas ID gevonden</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                @if(isset($testData['error']))
                    <div class="mb-4">
                        <h2 class="font-semibold text-red-700 mb-1">Error</h2>
                        <pre class="bg-red-50 p-2 rounded text-xs overflow-auto">{{ $testData['error'] }}</pre>

                        @if(isset($testData['trace']))
                            <details class="mt-2">
                                <summary class="cursor-pointer text-xs font-medium">Toon stack trace</summary>
                                <pre class="bg-red-50 p-2 mt-1 rounded text-xs overflow-auto h-40">{{ $testData['trace'] }}</pre>
                            </details>
                        @endif
                    </div>
                @endif
            </div>

            @if(isset($testData['logs']) && count($testData['logs']) > 0)
                <div class="mb-6">
                    <h2 class="font-semibold mb-2">Recente Logs</h2>
                    <div class="bg-gray-100 p-3 rounded">
                        <details>
                            <summary class="cursor-pointer font-medium">Toon logs ({{ count($testData['logs']) }})</summary>
                            <div class="mt-2 bg-gray-800 text-gray-100 p-3 rounded-md text-xs overflow-auto h-64">
                                @foreach($testData['logs'] as $log)
                                    <div class="mb-2 pb-2 border-b border-gray-700">{{ $log }}</div>
                                @endforeach
                            </div>
                        </details>
                    </div>
                </div>
            @endif

            <div class="flex justify-between items-center">
                <a href="{{ route('admin.students.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-arrow-left mr-1"></i> Terug naar studenten
                </a>

                <a href="{{ route('admin.test-canvas-api') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-redo mr-1"></i> Test opnieuw uitvoeren
                </a>
            </div>
        </div>
    </div>
@endsection
