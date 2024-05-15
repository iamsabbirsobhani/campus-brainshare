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
    <div class="flex justify-around">
        <x-usernav.menu />
    </div>


    <div class=" p-10 2xl:max-w-5xl xl:max-w-4xl border border-gray-200 m-0">
        <div>
            <h1 class="text-gray-600 text-2xl mb-5">User Profile</h1>
        </div>
        <!-- cover -->
        <div>

        </div>
        <!-- profile picture -->
        <div>
            <img src="https://maraviyainfotech.com/projects/ekka/ekka-v37/ekka-html/assets/images/user/1.jpg" alt="">
        </div>
        <!-- user details -->
        <div class="flex justify-between mb-4 items-center mt-3">
            <h1>Hello <span class="font-bold uppercase">{{ $username }}!</span></h1>

        </div>
        <div>
            <h1 class="font-light">{{ $bio }}</h1>
        </div>

        <div>
            <div class="font-bold mt-3 mb-3">Expertise:
                @forelse ($courses as $course)
                <li class="font-normal">{{ $course->name }}</li>
                @empty
                <p>No Expertise on any courses. Please add from Edit Profile</p>
                @endforelse
            </div>
        </div>
    </div>
    </div>
    <x-footer.footer />
</body>

</html>