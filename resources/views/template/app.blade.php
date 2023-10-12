<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>FintechSchool</title>
</head>

<body>
    <div class="container mx-auto">
        <div class="flex justify-between p-4">
            <div class="flex text-3xl font-bold">
                EFinance.
            </div>
            <div class="flex gap-3">
                <a href="/{{ !Auth::check() ? 'login' : 'logout' }}"
                    class="p-3 rounded-md text-white bg-slate-950">{{ !Auth::check() ? 'Login' : 'Logout' }}</a>
                <a href="/register" class="p-3 rounded-md border border-slate-950">Register</a>
            </div>
        </div>
    </div>
    @yield('content')
</body>

</html>
