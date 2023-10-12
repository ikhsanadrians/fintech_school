<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>FintechSchool</title>
</head>

<body>
    <!-- Navbar -->
    <div class="flex justify-between items-center p-4 border border-slate-300 border-r-0 border-l-0">
        <div class="text-3xl font-bold">
            <a href="/">EFinance.</a>
        </div>
        <div class="flex gap-3">
            <a href="{{ !Auth::check() ? '/login' : '/logout' }}"
                class="p-3 rounded-md text-white bg-slate-950">{{ !Auth::check() ? 'Login' : 'Logout' }}</a>
        </div>
    </div>

    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-60 p-4 border border-slate-300 border-t-0">
            <ul class="space-y-4">
                <li>
                    <a href="/" class="hover:text-gray-300">Home</a>
                </li>
                <li>
                    <a href="/clothings" class="hover:text-gray-300">Clothing</a>
                </li>
                <li>
                    <a href="/foods" class="hover:text-gray-300">Foods</a>
                </li>
                <li>
                    <a href="/drinks" class="hover:text-gray-300">Drinks</a>
                </li>
                <div class="flex w-full bg-slate-300 border border-b-1"></div>
                <li>
                    <a href="/history" class="hover:text-gray-300">History</a>
                </li>
                <li>
                    <span class="hover:text-gray-300 cursor-pointer" id="openModal">Top Up</span>
                    <div id="myModal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
                        <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>

                        <div
                            class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">

                            <!-- Isi Modal Anda -->
                            <div class="modal-content py-4 text-left px-6">
                                <h1 class="text-2xl font-semibold mb-4">Top Up Wallet</h1>
                                <form action="{{ route('topUp') }}" method="post">
                                    @csrf
                                    <span class="text-lg mr-2">Rp</span>
                                    <input type="number" name="credit"
                                        class="rounded border border-slate-300 p-2 mr-3" value="10000">
                                    <button type="submit"
                                        class="px-4 py-2 bg-gray-900 text-white rounded-lg focus:outline-none focus:shadow-outline">Top
                                        Up</button>
                                </form>
                                <!-- Tombol Tutup Modal -->
                                <div class="mt-5">
                                    <button id="closeModal"
                                        class="modal-close px-4 py-2 bg-gray-900 text-white rounded-lg focus:outline-none focus:shadow-outline">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </li>
                <div class="flex w-full bg-slate-300 border border-b-1"></div>
                <li>
                    <a href="/settings" class="hover:text-gray-300">Settings</a>
                </li>
                @yield('sidebar_features')
            </ul>
        </div>

        <!-- Konten Utama -->
        <div class="flex-1 p-4 w-full">
            @yield('content')
        </div>
    </div>
    <script>
        // Ambil elemen-elemen modal dan tombol
        const modal = document.getElementById('myModal');
        const openModal = document.getElementById('openModal');
        const closeModal = document.getElementById('closeModal');

        // Fungsi untuk membuka modal
        function open() {
            modal.classList.remove('hidden');
        }

        // Fungsi untuk menutup modal
        function close() {
            modal.classList.add('hidden');
        }

        // Tambahkan event listener untuk membuka modal
        openModal.addEventListener('click', open);

        // Tambahkan event listener untuk menutup modal
        closeModal.addEventListener('click', close);
    </script>

</body>

</html>
