<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>FintechSchool</title>
</head>

<body class="bg-[#F0F7F4]">
    <!-- Navbar -->
    <div
        class="flex justify-between items-center p-4 border border-slate-300 border-r-0 border-l-0 overflow-y-hidden bg-white">
        <div class="text-3xl font-bold">
            <a href="/">EFinance.</a>
        </div>
        <div class="flex gap-3">
            <a href="{{ !Auth::check() ? '/login' : '/logout' }}"
                class="p-3 rounded-md text-white bg-slate-950">{{ !Auth::check() ? 'Login' : 'Logout' }}</a>
        </div>
    </div>

    <div class="flex h-screen fixed overflow-hidden w-full">
        <!-- Sidebar -->
        <div class="w-60 p-4 border border-slate-300 border-t-0 bg-white">
            <ul class="space-y-3">
                @yield('sidebar_features')
                <li class="flex items-center gap-3">
                    <div class="flex flex-col items-center justify-center bg-slate-950 rounded-full p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="fill-white" viewBox="0 0 16 16">
                            <path
                                d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5ZM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5 5 5Z" />
                        </svg>
                    </div>
                    <a href="/admin" class="hover:text-gray-300">Home</a>
                </li>
                <li class="flex items-center gap-3">
                    <div class="flex flex-col items-center justify-center bg-slate-950 rounded-full p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="fill-white" viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                            <path
                                d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12z" />
                        </svg>
                    </div>
                    <a href="/transaction" class="hover:text-gray-300">Transaction</a>
                </li>
                <li class="flex items-center gap-3">
                    <div class="flex flex-col items-center justify-center bg-slate-950 rounded-full p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="fill-white" viewBox="0 0 16 16">
                            <path
                                d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v1h14V4a1 1 0 0 0-1-1H2zm13 4H1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V7z" />
                            <path d="M2 10a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1z" />
                        </svg>
                    </div>
                    <a href="/list-top-up" class="hover:text-gray-300">Top Up</a>
                </li>
            </ul>
        </div>

        <!-- Konten Utama -->
        <div class="flex-1 p-4 w-full overflow-y-auto">
            @yield('content')
        </div>
    </div>

</body>

</html>
