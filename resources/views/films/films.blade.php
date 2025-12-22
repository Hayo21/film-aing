<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>Film Aing</title>
    <style>
        body {
            background-color: #0F172A;
        }
    </style>
</head>

<body>
    {{-- navbar --}}
    <x-navbar />
    {{-- end navbar --}}

    {{-- jumbotron --}}
    <div class="container mx-auto px-4 py-8 mt-20">
        <h1>Halaman films</h1>
    </div>
    {{-- jumbotron --}}
</body>

</html>
