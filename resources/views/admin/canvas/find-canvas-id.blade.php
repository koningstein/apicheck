@extends('layouts.layoutadmin')

@section('content')
    <div class="card mt-6">
        <div class="card-header flex flex-row justify-between">
            <h1 class="h6">Zoek Canvas ID voor Eduarte ID</h1>
            <a href="{{ route('admin.canvas-test.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                <i class="fas fa-arrow-left mr-1"></i> Terug naar tests
            </a>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.canvas-test.find-canvas-id') }}" method="POST" class="mb-6 bg-white p-6 rounded-lg shadow-md">
                @csrf
                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                    <div class="flex-grow">
                        <label for="eduarte_id" class="block text-sm font-medium text-gray-700">Eduarte ID</label>
                        <input type="text" name="eduarte_id" id="eduarte_id" value="{{ request('eduarte_id') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-search mr-1"></i> Zoek
                        </button>
                    </div>
                </div>
            </form>

            @if($error)
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                    <p class="font-bold">Fout</p>
                    <p>{{ $error }}</p>
                </div>
            @endif

            @if($result)
                <div class="mb-6">
                    <div class="bg-{{ $result['success'] ? 'green' : 'yellow' }}-100 border-l-4 border-{{ $result['success'] ? 'green' : 'yellow' }}-500 p-4 mb-4">
                        @if($result['success'])
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 text-2xl mr-2"></i>
                                <div>
                                    <p class="font-bold text-green-700">Canvas ID gevonden!</p>
                                    <p class="text-green-700">Canvas ID voor Eduarte ID {{ $result['eduarte_id'] }} is: <span class="font-mono font-bold">{{ $result['canvas_id'] }}</span></p>
                                    <p class="text-sm text-green-600">Gevonden in veld: {{ $result['match_field'] ?? 'onbekend' }}</p>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle text-yellow-500 text-2xl mr-2"></i>
                                <div>
                                    <p class="font-bold text-yellow-700">Canvas ID niet gevonden</p>
                                    <p class="text-yellow-700">Er is geen Canvas ID gevonden voor Eduarte ID {{ $result['eduarte_id'] }}</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-800">Zoekresultaat Details</h2>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <h3 class="font-medium text-gray-700">Zoekopdracht</h3>
                                    <div class="mt-2 bg-gray-100 p-3 rounded">
                                        <p class="text-sm">Eduarte ID: <span class="font-mono">{{ $result['eduarte_id'] }}</span></p>
                                        <p class="text-sm">Tijd: {{ $result['time_taken'] }} seconden</p>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-700">Statistieken</h3>
                                    <div class="mt-2 bg-gray-100 p-3 rounded">
                                        <p class="text-sm">Cursussen gecontroleerd: {{ $result['courses_checked'] }}</p>
                                        <p class="text-sm">Studenten gecontroleerd: {{ $result['students_checked'] }}</p>
                                        <p class="text-sm">Fouten: {{ count($result['errors']) }}</p>
                                    </div>
                                </div>
                            </div>

                            @if($result['success'] && isset($result['user_detail']))
                                <div class="mb-4">
                                    <h3 class="font-medium text-gray-700 mb-2">Gebruikersdetails</h3>
                                    <div class="bg-gray-100 p-3 rounded">
                                        <table class="min-w-full">
                                            <tbody>
                                            <tr>
                                                <td class="py-1 pr-4 font-medium text-sm">Canvas ID:</td>
                                                <td class="py-1 font-mono text-sm">{{ $result['user_detail']['id'] }}</td>
                                            </tr>
                                            <tr>
                                                <td class="py-1 pr-4 font-medium text-sm">Naam:</td>
                                                <td class="py-1 text-sm">{{ $result['user_detail']['name'] }}</td>
                                            </tr>
                                            @if(!empty($result['user_detail']['login_id']))
                                                <tr>
                                                    <td class="py-1 pr-4 font-medium text-sm">Login ID:</td>
                                                    <td class="py-1 font-mono text-sm">{{ $result['user_detail']['login_id'] }}</td>
                                                </tr>
                                            @endif
                                            @if(!empty($result['user_detail']['sis_user_id']))
                                                <tr>
                                                    <td class="py-1 pr-4 font-medium text-sm">SIS User ID:</td>
                                                    <td class="py-1 font-mono text-sm">{{ $result['user_detail']['sis_user_id'] }}</td>
                                                </tr>
                                            @endif
                                            @if(!empty($result['user_detail']['email']))
                                                <tr>
                                                    <td class="py-1 pr-4 font-medium text-sm">Email:</td>
                                                    <td class="py-1 font-mono text-sm">{{ $result['user_detail']['email'] }}</td>
                                                </tr>
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif

                            @if(count($result['errors']) > 0)
                                <div class="mb-4">
                                    <h3 class="font-medium text-gray-700 mb-2">Fouten</h3>
                                    <div class="bg-red-50 p-3 rounded">
                                        <ul class="list-disc list-inside text-sm text-red-600">
                                            @foreach($result['errors'] as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif

                            <div>
                                <h3 class="font-medium text-gray-700 mb-2">Zoeklog</h3>
                                <div class="bg-gray-800 text-gray-200 p-4 rounded-md h-96 overflow-auto">
                                    @foreach($result['search_log'] as $log)
                                        <div class="mb-1 flex">
                                            <span class="inline-block w-16 text-xs {{ $log['level'] === 'error' ? 'text-red-400' : ($log['level'] === 'warning' ? 'text-yellow-400' : 'text-blue-400') }}">
                                                [{{ strtoupper($log['level']) }}]
                                            </span>
                                            <span class="text-xs">{{ $log['message'] }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
