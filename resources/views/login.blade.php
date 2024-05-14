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
    <!-- It is quality rather than quantity that matters. - Lucius Annaeus Seneca -->
    <x-navbar.navbar />
    <div class="flex justify-center gap-20 mt-10 mb-10 shadow-md 2xl:w-[912px] xl:w-[1012px] m-auto text-gray-700 p-5">
        <div>
            <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>

            <dotlottie-player src="https://lottie.host/cba17167-e31a-4d70-968b-33840fac75ad/qhFm8X2geu.json" background="transparent" speed="0.5" style="width: 450px; height: 450px;" loop autoplay></dotlottie-player>
        </div>
        <div>
            <div>
                <h1 class="text-2xl font-bold">Welcome back!</h1>
                <p>Please <span class="text-blue-500 underline font-bold">login</span> to continue</p>
            </div>
            <form action="/userlogin" method="post" class="mt-10">
                @csrf
                <div class="flex flex-col">
                    <label for="email">Email:</label>
                    <input class="outline-none border-2 w-full border-gray-200 p-3" type="email" name="email" id="email" required placeholder="please enter mail">
                </div>
                <div class="flex flex-col mt-5">
                    <label for="password">Password:</label>
                    <input class="outline-none border-2 w-full border-gray-200 p-3" type="password" name="password" id="password" required placeholder="please enter password">
                </div>
                <div class="text-center mt-5 ">
                    <button type="submit" class="bg-blue-500 p-2 w-full uppercase font-bold text-gray-50 rounded-sm">Login</button>
                </div>

                <div class="flex justify-evenly items-center mt-6 mb-6">
                    <div class="w-14 h-[2px] bg-gray-200"></div>
                    <div>
                        <h1>Or</h1>
                    </div>
                    <div class="w-14 h-[2px] bg-gray-200"></div>
                </div>
                <div>
                    <p class="text-center mt-5">Don't have an account? <a href="/register" class="text-blue-500 font-bold underline underline-offset-1 text-lg">Register</a></p>
                </div>
            </form>
        </div>
    </div>
    <x-footer.footer />
</div>
</body>

</html>