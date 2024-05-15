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
    @if ($er_msg)
    <div class="bg-red-500 text-gray-50 font-bold w-fit m-auto p-5 mt-5 mb-5 rounded-sm">
        <h1>{{$er_msg}}</h1>
    </div>
    @endif

    <div class="">
        <!-- It is quality rather than quantity that matters. - Lucius Annaeus Seneca -->
        <div class="flex justify-center gap-24">
            <x-usernav.menu />
        </div>
        <div class="border border-gray-200 w-96 p-3">
            <form action="/usereditprofile" method="POST" class="mt-8" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="bio" class="block text-gray-700 text-sm font-bold mb-2">Bio:</label>
                    <textarea placeholder="please write down your bio" name="bio" id="bio" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500"></textarea>
                </div>
                <div class="mb-4">
                    <label for="expertise" class="block text-gray-700 text-sm font-bold mb-2">Expertise:</label>
                    <select name="expertise" id="expertise" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                        <option value="">Select Expertise</option>
                        <option value="CSE246">CSE246
                        </option>
                        <option value="CSE303">CSE303</option>
                        <option value="CSE479">CSE479</option>
                        <option value="CSE487">CSE487</option>
                        <option value="CSE366">CSE366</option>
                        <option value="CSE103">CSE103</option>
                        <option value="CSE106">CSE106</option>
                        <option value="CSE302">CSE302</option>
                        <option value="CSE345">CSE345</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="available" class="block text-gray-700 text-sm font-bold mb-2">Availability:</label>
                    <select name="available" id="available" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                        <option value="">Select Availability</option>
                        <option value="1">True</option>
                        <option value="0">False</option>
                    </select>
                </div>

                <div class="mt-5 mb-5">
                    <label for="profile_pic" class="block text
                    -gray-700 text-sm font-bold mb-2">Profile Picture:</label>
                    <input type="file" name="profile_pic" id="profile_pic" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Save</button>
                </div>
            </form>
        </div>
    </div>
    <x-footer.footer />
</body>

</html>