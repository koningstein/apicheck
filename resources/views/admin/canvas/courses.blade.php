@extends('layouts.layoutadmin')

@section('content')
    <div class="card mt-6">
        <div class="card-header flex flex-row justify-between">
            <h1 class="h6">Canvas Cursussen</h1>
            <a href="{{ route('admin.canvas-test.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                <i class="fas fa-arrow-left mr-1"></i> Terug naar tests
            </a>
        </div>

        <div class="card-body">
            @if($error)
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                    <p class="font-bold">Fout</p>
                    <p>{{ $error }}</p>
                </div>
            @endif

            <div class="bg-blue-100 border-l-4 border-blue-500 p-4 mb-6">
                <div class="flex items-center">
                    <i class="fas fa-info-circle text-blue-500 text-2xl mr-2"></i>
                    <div>
                        <p class="font-bold text-blue-700">Canvas Cursussen</p>
                        <p class="text-blue-700">{{ $total }} cursussen gevonden</p>
                        <p class="text-sm text-blue-600">Gesorteerd op aantal studenten (indien beschikbaar)</p>
                    </div>
                </div>
            </div>

            @if(count($courses) > 0)
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                        <h2 class="text-lg font-semibold text-gray-800">Cursussen</h2>
                        <div class="flex space-x-2">
                            <div class="relative">
                                <input id="courseSearch" type="text" placeholder="Zoek op naam..."
                                       class="block w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200" id="coursesTable">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Naam</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cursus Code</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Studenten</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Term / Periode</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($courses as $course)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900">{{ $course['id'] }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ $course['name'] }}
                                        @if(!empty($course['workflow_state']) && $course['workflow_state'] !== 'available')
                                            <span class="ml-2 px-2 py-0.5 text-xs rounded {{ $course['workflow_state'] === 'completed' ? 'bg-gray-200' : 'bg-yellow-200' }}">
                                                    {{ $course['workflow_state'] }}
                                                </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $course['course_code'] ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if(isset($course['total_students']))
                                            <span class="font-medium">{{ $course['total_students'] }}</span>
                                        @else
                                            <span class="text-gray-400">N/A</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $course['term']['name'] ?? '-' }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-gray-100 p-4 rounded-lg">
                    <h3 class="text-md font-semibold text-gray-700 mb-2">Cursussen gebruiken voor Canvas ID zoeken</h3>
                    <p class="text-sm text-gray-600 mb-2">Bij het zoeken naar Canvas ID's op basis van Eduarte ID's, is het belangrijk te weten:</p>
                    <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                        <li>De cursussen bovenaan de lijst (met de meeste studenten) worden eerst doorzocht</li>
                        <li>Alleen studenten die ingeschreven zijn in een cursus kunnen worden gevonden</li>
                        <li>Cursussen met status "completed" kunnen nog steeds gebruikbare studentgegevens bevatten</li>
                        <li>Het zoeken door alle cursussen kan enige tijd duren, maar verhoogt de kans om Canvas ID's te vinden</li>
                    </ul>
                </div>
            @endif
        </div>
    </div>

    <script>
        // Eenvoudige zoekfunctionaliteit voor de cursustabel
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('courseSearch');
            const table = document.getElementById('coursesTable');
            const rows = table.querySelectorAll('tbody tr');

            searchInput.addEventListener('keyup', function() {
                const query = this.value.toLowerCase();

                rows.forEach(row => {
                    const courseName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                    const courseCode = row.querySelector('td:nth-child(3)').textContent.toLowerCase();

                    if (courseName.includes(query) || courseCode.includes(query)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    </script>
@endsection
