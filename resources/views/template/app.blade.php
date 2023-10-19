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
                <a href="/">EFinance.</a>
            </div>
            <div class="flex gap-3 items-center">
                <a href="/history">Inbox</a>
                <a href="/clothings">clothings</a>
                <a href="/foods">foods</a>
                <a href="/drinks">drinks</a>
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
                                <input type="number" name="credit" class="rounded border border-slate-300 p-2 mr-3"
                                    value="10000">
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
                <a href="/{{ !Auth::check() ? 'login' : 'logout' }}"
                    class="p-3 rounded-md text-white bg-slate-950">{{ !Auth::check() ? 'Login' : 'Logout' }}</a>
                <a href="/register" class="p-3 rounded-md border border-slate-950">Register</a>
            </div>
        </div>
    </div>
    @yield('content')
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
