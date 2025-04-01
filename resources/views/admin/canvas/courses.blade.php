<!DOCTYPE html>
<html>
<head>
    <title>Canvas Cursussen</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Canvas Cursussen</h1>

    @if($status === 'success')
        <div class="bg-white shadow-md rounded mb-6">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Naam</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cursus Code</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acties</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach($courses as $course)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $course['id'] }}</td>
                        <td class="px-6 py-4">{{ $course['name'] }}</td>
                        <td class="px-6 py-4">{{ $course['course_code'] ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <a href="#" class="text-blue-600 hover:text-blue-900">Details</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <strong class="font-bold">Fout!</strong>
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="mt-4">
        <a href="{{ route('canvas.test') }}" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Test Verbinding</a>
        <a href="{{ route('dashboard') }}" class="inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Terug naar Dashboard</a>
    </div>
</div>
</body>
</html>
