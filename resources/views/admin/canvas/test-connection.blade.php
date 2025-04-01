<!DOCTYPE html>
<html>
<head>
    <title>Canvas API Verbindingstest</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Canvas API Verbindingstest</h1>

    @if($status === 'success')
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <strong class="font-bold">Succes!</strong>
            <p>{{ $message }}</p>

            @if(isset($courses_count))
                <p class="mt-2">Aantal cursussen gevonden: {{ $courses_count }}</p>
                @if(isset($first_course))
                    <p>Eerste cursus: {{ $first_course }}</p>
                @endif
            @endif
        </div>
    @else
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <strong class="font-bold">Fout!</strong>
            <p>{{ $message }}</p>
        </div>

        <div class="bg-white shadow-md rounded p-4 mb-6">
            <h2 class="text-xl font-semibold mb-2">Error Details</h2>
            <pre class="bg-gray-100 p-4 rounded overflow-auto">{{ $error }}</pre>
        </div>
    @endif

    <div class="mt-4">
        <a href="{{ route('canvas.courses') }}" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Toon Canvas Cursussen</a>
        <a href="{{ route('dashboard') }}" class="inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Terug naar Dashboard</a>
    </div>
</div>
</body>
</html>
