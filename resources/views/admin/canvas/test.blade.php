@extends('layouts.layoutadmin')

@section('content')
    <div class="card mt-6">
        <div class="card-header flex flex-row justify-between">
            <h1 class="h6">Canvas API Test Tools</h1>
        </div>

        <div class="card-body">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold mb-3 text-gray-800">API Verbinding Testen</h2>
                    <p class="text-gray-600 mb-4">Test de verbinding met Canvas API door een simpele API call te maken.</p>
                    <a href="{{ route('admin.canvas-test.connection') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-plug mr-1"></i> Test Verbinding
                    </a>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold mb-3 text-gray-800">Canvas ID Zoeken</h2>
                    <p class="text-gray-600 mb-4">Zoek Canvas ID op basis van Eduarte ID met gedetailleerd resultaat.</p>
                    <form action="{{ route('admin.canvas-test.find-canvas-id') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="eduarte_id" class="block text-sm font-medium text-gray-700">Eduarte ID</label>
                            <input type="text" name="eduarte_id" id="eduarte_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-search mr-1"></i> Zoek Canvas ID
                        </button>
                    </form>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold mb-3 text-gray-800">Batch Canvas ID Zoeken</h2>
                    <p class="text-gray-600 mb-4">Zoek meerdere Canvas ID's in één keer (max. 10).</p>
                    <form action="{{ route('admin.canvas-test.batch-find-canvas-ids') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="eduarte_ids" class="block text-sm font-medium text-gray-700">Eduarte ID's (één per regel of komma-gescheiden)</label>
                            <textarea name="eduarte_ids" id="eduarte_ids" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                        </div>
                        <button type="submit" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-search-plus mr-1"></i> Zoek Canvas ID's
                        </button>
                    </form>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold mb-3 text-gray-800">Canvas Cursussen</h2>
                    <p class="text-gray-600 mb-4">Bekijk alle beschikbare cursussen gesorteerd op aantal studenten.</p>
                    <a href="{{ route('admin.canvas-test.courses') }}" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-book mr-1"></i> Toon Cursussen
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
