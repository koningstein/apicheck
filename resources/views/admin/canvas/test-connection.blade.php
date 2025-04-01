@extends('layouts.layoutadmin')

@section('content')
    <div class="card mt-6">
        <div class="card-header flex flex-row justify-between">
            <h1 class="h6">Canvas API Verbindingstest</h1>
            <a href="{{ route('admin.canvas-test.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                <i class="fas fa-arrow-left mr-1"></i> Terug naar tests
            </a>
        </div>

        <div class="card-body">
            <div class="mb-6 p-4 {{ $success ? 'bg-green-100 border border-green-400 text-green-700' : 'bg-red-100 border border-red-400 text-red-700' }} rounded relative">
                <div class="flex items-center">
                    @if($success)
                        <i class="fas fa-check-circle text-green-500 text-2xl mr-3"></i>
                    @else
                        <i class="fas fa-times-circle text-red-500 text-2xl mr-3"></i>
                    @endif

                    <div>
                        <div class="font-bold text-lg">
                            {{ $success ? 'Verbinding succesvol' : 'Verbinding mislukt' }}
                        </div>
                        <p>{{ $message }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-800">Details</h2>
                </div>

                <div class="p-6">
                    @if($success)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-gray-100 p-4 rounded">
                                <h3 class="font-medium text-gray-700 mb-2">API Status</h3>
                                <ul class="space-y-1">
                                    <li class="text-sm flex items-start">
                                        <span class="font-medium w-32">Status:</span>
                                        <span class="text-green-600">OK</span>
                                    </li>
                                    @if(isset($details['courses_count']))
                                        <li class="text-sm flex items-start">
                                            <span class="font-medium w-32">Cursussen:</span>
                                            <span>{{ $details['courses_count'] }}</span>
                                        </li>
                                    @endif
                                    @if(isset($details['first_course']))
                                        <li class="text-sm flex items-start">
                                            <span class="font-medium w-32">Voorbeeld cursus:</span>
                                            <span class="truncate">{{ $details['first_course'] }}</span>
                                        </li>
                                    @endif
                                </ul>
                            </div>

                            <div class="bg-gray-100 p-4 rounded">
                                <h3 class="font-medium text-gray-700 mb-2">Canvas API Instellingen</h3>
                                <ul class="space-y-1">
                                    <li class="text-sm flex items-start">
                                        <span class="font-medium w-32">API URL:</span>
                                        <span class="truncate">{{ preg_replace('/^(https?:\/\/)([^\/]+)(.*)$/', '$1$2', $details['apiUrl'] ?? 'Niet beschikbaar') }}</span>
                                    </li>
                                    <li class="text-sm flex items-start">
                                        <span class="font-medium w-32">API Token:</span>
                                        <span>{{ isset($details['apiToken']) ? substr($details['apiToken'], 0, 5) . '••••••••••••••••••••' : 'Niet beschikbaar' }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="mt-6">
                            <h3 class="font-medium text-gray-700 mb-2">Volgende stappen</h3>
                            <div class="bg-blue-50 p-4 rounded">
                                <p class="text-sm text-blue-700 mb-3">Nu de verbinding werkt, kun je de volgende tests uitvoeren:</p>
                                <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-2">
                                    <a href="{{ route('admin.canvas-test.find-canvas-id') }}" class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-medium py-2 px-4 rounded">
                                        <i class="fas fa-search mr-1"></i> Canvas ID zoeken
                                    </a>
                                    <a href="{{ route('admin.canvas-test.courses') }}" class="bg-green-500 hover:bg-green-700 text-white text-sm font-medium py-2 px-4 rounded">
                                        <i class="fas fa-book mr-1"></i> Cursussen bekijken
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="bg-red-50 p-4 rounded">
                            <h3 class="font-medium text-red-700 mb-2">Foutdetails</h3>
                            @if(isset($details['error']))
                                <pre class="text-xs overflow-auto bg-gray-100 p-3 rounded max-h-64">{{ $details['error'] }}</pre>
                            @endif

                            <h3 class="font-medium text-red-700 mt-4 mb-2">Mogelijke oorzaken</h3>
                            <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                                <li>De Canvas API URL is onjuist</li>
                                <li>De API token is ongeldig of verlopen</li>
                                <li>De API token heeft onvoldoende rechten</li>
                                <li>Er is een netwerkprobleem tussen de server en Canvas</li>
                                <li>Canvas is momenteel niet beschikbaar</li>
                            </ul>

                            <h3 class="font-medium text-red-700 mt-4 mb-2">Oplossingen</h3>
                            <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                                <li>Controleer de Canvas API URL en API token in de instellingen</li>
                                <li>Genereer een nieuwe API token in Canvas</li>
                                <li>Controleer of de API token de juiste rechten heeft</li>
                                <li>Controleer de netwerkinstellingen en firewall</li>
                            </ul>
                        </div>

                        <div class="mt-6">
                            <a href="{{ route('admin.canvas-settings.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded">
                                <i class="fas fa-cog mr-1"></i> Canvas instellingen aanpassen
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
