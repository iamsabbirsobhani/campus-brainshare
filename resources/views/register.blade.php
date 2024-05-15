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

</body>
<div>
    <!-- Waste no more time arguing what a good man should be, be one. - Marcus Aurelius -->
    <x-navbar.navbar />
    <div class="flex justify-evenly gap-20 mt-10 mb-10 shadow-md 2xl:w-[912px] xl:w-[1012px] m-auto text-gray-700 p-8 items-center">

        <div>
            <div>
                <h1 class="text-2xl font-bold">One more step to go!</h1>
                <p>Please <span class="text-blue-500 underline font-bold">sign up</span> to continue</p>
            </div>
            <form action="/register" method="post" class="mt-10">
                @csrf
                <div class="flex flex-col">
                    <label for="name">Name:</label>
                    <input class="outline-none border-2 w-full border-gray-200 p-3" type="text" name="name" id="name" required placeholder="please enter mail">
                </div>
                <div class="flex flex-col mt-5">
                    <label for="email">Email:</label>
                    <input class="outline-none border-2 w-full border-gray-200 p-3" type="email" name="email" id="email" required placeholder="please enter mail">
                </div>
                <div class="flex flex-col mt-5">
                    <label for="password">Set Password:</label>
                    <input class="outline-none border-2 w-full border-gray-200 p-3" type="password" name="password" id="password" required placeholder="please enter password">
                </div>
                <!-- account type  -->
                <div class="flex flex-col mt-5">
                    <label for="account_type">Account Type:</label>
                    <select class="outline-none border-2 w-full border-gray-200 p-3" name="account_type" id="account_type" required>
                        <option value="TechMentor">TechMentor</option>
                        <option value="KnowledgeSeeker">KnowledgeSeeker</option>
                    </select>
                </div>

                <!-- gender -->

                <div class="flex flex-col mt-5">
                    <label for="gender">Gender:</label>
                    <select class="outline-none border-2 w-full border-gray-200 p-3" name="gender" id="gender" required>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
                <div class="text-center mt-5 ">
                    <button type="submit" class="bg-blue-500 p-2 w-full uppercase font-bold text-gray-50 rounded-sm">Create account</button>
                </div>

                <div class="flex justify-evenly items-center mt-6 mb-6">
                    <div class="w-14 h-[2px] bg-gray-200"></div>
                    <div>
                        <h1>Or</h1>
                    </div>
                    <div class="w-14 h-[2px] bg-gray-200"></div>
                </div>
                <div>
                    <p class="text-center mt-5">Already have an account? <a href="/login" class="text-blue-500 font-bold underline underline-offset-1 text-lg">Login</a></p>
                </div>
            </form>
        </div>
        <div>
            <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>

            <dotlottie-player src="https://lottie.host/530ec38d-d787-42a6-a3e8-be90c323a5d6/PBxAutmMU9.json" background="transparent" speed="0.5" style="width: 400px; height: 400px;" loop autoplay></dotlottie-player>
        </div>
    </div>
    <x-footer.footer />
</div>
</body>

</html>