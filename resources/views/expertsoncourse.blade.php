<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Campus Brainshare</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
</head>

<body>
    <x-navbar.navbar />
    <h1>Search Expertise</h1>
    @forelse ($experts as $expert)
    <div class="w-[600px] m-auto border rounded-lg border-gray-200 p-5 mt-5 mb-5">
        <div>
            <!-- profile photo -->
            <div></div>
            <div>
                <h1 class="uppercase font-bold text-xl">{{ $expert->name }}</h1>
                <p class="mt-3 font-light">{{ $expert->bio }}</p>
                <p>{{ $expert->profilephotourl}}</p>
                <p>{{ $expert->email}}</p>
            </div>
            <div class="mt-3">
                <button class="w-full bg-blue-500 p-3 font-bold rounded-md text-gray-50">Send Message</button>
            </div>
        </div>
    </div>

    @empty
    <div class="bg-red-500 text-gray-50 font-bold w-fit m-auto p-5 mt-5 mb-5 rounded-sm">
        <p>No experts found!</p>
    </div>
    @endforelse
    <x-footer.footer />
</body>

</html>