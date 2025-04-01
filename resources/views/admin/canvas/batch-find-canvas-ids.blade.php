@extends('layouts.layoutadmin')

@section('content')
    <div class="card mt-6">
        <div class="card-header flex flex-row justify-between">
            <h1 class="h6">Batch Canvas ID Zoeken</h1>
            <a href="{{ route('admin.canvas-test.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                <i class="fas fa-arrow-left mr-1"></i> Terug naar tests
            </a>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.canvas-test.batch-find-canvas-ids') }}" method="POST" class="mb-6 bg-white p-6 rounded-lg shadow-md">
                @csrf
                <div>
                    <label for="eduarte_ids" class="block text-sm font-medium text-gray-700">Eduarte ID's (één per regel of komma-gescheiden, max. 10)</label>
                    <textarea name="eduarte_ids" id="eduarte_ids" rows="5"
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ request('eduarte_ids') }}</textarea>
                </div>
                <div class="mt-4">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-search-plus mr-1"></i> Zoek Canvas ID's
                    </button>
                </div>
            </form>

            @if($error)
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                    <p class="font-bold">Fout</p>
                    <p>{{ $error }}</p>
                </div>
            @endif

            @if(isset($results) && is_array($results) && count($results) > 0)
                <div class="mb-6">
                    <div class="bg-blue-100 border-l-4 border-blue-500 p-4 mb-4">
                        <div class="flex items-center">
                            <i class="fas fa-info-circle text-blue-500 text-2xl mr-2"></i>
                            <div>
                                <p class="font-bold text-blue-700">Zoekresultaten</p>
                                <p class="text-blue-700">Gevonden: {{ $summary['found'] }} / {{ $summary['total'] }} ({{ round(($summary['found'] / $summary['total']) * 100) }}%)</p>
                                <p class="text-sm text-blue-600">Niet gevonden: {{ $summary['not_found'] }}, Fouten: {{ $summary['errors'] }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-800">Resultaten</h2>
                        </div>
                        <div class="p-6">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Eduarte ID</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Canvas ID</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Details</th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($results as $result)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap font-mono text-sm text-gray-900">{{ $result['eduarte_id'] }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap font-mono text-sm text-gray-900">
                                                {{ $result['canvas_id'] ?: '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($result['found'])
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                            Gevonden
                                                        </span>
                                                @else
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                            Niet gevonden
                                                        </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if(isset($result['error']))
                                                    <span class="text-red-500">{{ $result['error'] }}</span>
                                                @else
                                                    @if($result['found'])
                                                        <a href="{{ route('admin.canvas-test.find-canvas-id', ['eduarte_id' => $result['eduarte_id']]) }}" class="text-blue-600 hover:text-blue-900">
                                                            Details bekijken
                                                        </a>
                                                    @else
                                                        -
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
