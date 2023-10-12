@extends('template.app_home')

@section('sidebar_features')
    <p></p>
    <div class="flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-coin"
            viewBox="0 0 16 16">
            <path
                d="M5.5 9.511c.076.954.83 1.697 2.182 1.785V12h.6v-.709c1.4-.098 2.218-.846 2.218-1.932 0-.987-.626-1.496-1.745-1.76l-.473-.112V5.57c.6.068.982.396 1.074.85h1.052c-.076-.919-.864-1.638-2.126-1.716V4h-.6v.719c-1.195.117-2.01.836-2.01 1.853 0 .9.606 1.472 1.613 1.707l.397.098v2.034c-.615-.093-1.022-.43-1.114-.9H5.5zm2.177-2.166c-.59-.137-.91-.416-.91-.836 0-.47.345-.822.915-.925v1.76h-.005zm.692 1.193c.717.166 1.048.435 1.048.91 0 .542-.412.914-1.135.982V8.518l.087.02z" />
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
            <path d="M8 13.5a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11zm0 .5A6 6 0 1 0 8 2a6 6 0 0 0 0 12z" />
        </svg>
        <span class="font-bold text-xl">saldo: {{ $difference }}</span>

    </div>
@endsection

@section('content')
    <div class="container mx-auto h-screen overflow-y-auto">
        <div class="flex flex-col gap-3 ">
            <div class="flex items-center gap-4 w-full">
                <div class="rounded-full bg-slate-950 p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                        class="fill-white" viewBox="0 0 16 16">
                        <path
                            d="M5.757 1.071a.5.5 0 0 1 .172.686L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1v4.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 13.5V9a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h1.217L5.07 1.243a.5.5 0 0 1 .686-.172zM2 9v4.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V9H2zM1 7v1h14V7H1zm3 3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 4 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 6 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 8 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5z" />
                    </svg>
                </div>
                <span class="w-full">keranjang</span>
            </div>
            @php
                $totalPrice = 0;
            @endphp
            @foreach ($transactionsKeranjang as $ts)
                <div class="flex items-center gap-3 w-full">
                    <li class="flex w-full">{{ $ts->products->name }} | {{ $ts->price }} | {{ $ts->quantity }}</li>
                    <form action="/keranjang/delete" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="id" value="{{ $ts->id }}">
                        <button type="submit" class="bg-red-400 p-2 rounded-md">cancel</button>
                    </form>
                </div>
                @php
                    $totalPrice += $ts->price * $ts->quantity;
                @endphp
            @endforeach
            <p>total harga: {{ $totalPrice }}</p>
            <form action="{{ route('payProduct') }}" method="post" class="flex w-full">
                @csrf
                @method('PUT')
                <button type="submit" class="p-2 bg-slate-200 rounded-lg w-full">Check Out</button>
            </form>
            <div class="flex w-full bg-slate-300 border border-b-1"></div>

            <div class="flex flex-col w-full">
                <div class="flex items-center gap-5 w-full">
                    <div class="rounded-full bg-slate-950 p-3 flex">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            class="fill-white" viewBox="0 0 16 16">
                            <path d="M8 10a2 2 0 1 0 0-4 2 2 0 0 0 0 4z" />
                            <path
                                d="M0 4a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V4zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V6a2 2 0 0 1-2-2H3z" />
                        </svg>
                    </div>
                    <span class="w-full">Pembayaran</span>
                </div>
                <div class="flex flex-col">
                    @foreach ($transactionsBayar as $ts)
                        <li class="mt-3">{{ $ts->products->name }} | {{ $ts->price }} | {{ $ts->quantity }}</li>
                    @endforeach
                    @foreach ($walletProcess as $wp)
                        <li class="mt-3">Top Up Rp. {{ $wp->credit }} | {{ $wp->status }}</li>
                    @endforeach
                </div>
            </div>
            <div class="flex w-full bg-slate-300 border border-b-1"></div>
            <div class="flex flex-col w-full gap-4">
                <div class="flex items-center gap-6 w-full">
                    <div class="rounded-full bg-slate-950 p-3 flex">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="fill-white" viewBox="0 0 16 16">
                            <path
                                d="M14.778.085A.5.5 0 0 1 15 .5V8a.5.5 0 0 1-.314.464L14.5 8l.186.464-.003.001-.006.003-.023.009a12.435 12.435 0 0 1-.397.15c-.264.095-.631.223-1.047.35-.816.252-1.879.523-2.71.523-.847 0-1.548-.28-2.158-.525l-.028-.01C7.68 8.71 7.14 8.5 6.5 8.5c-.7 0-1.638.23-2.437.477A19.626 19.626 0 0 0 3 9.342V15.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 1 0v.282c.226-.079.496-.17.79-.26C4.606.272 5.67 0 6.5 0c.84 0 1.524.277 2.121.519l.043.018C9.286.788 9.828 1 10.5 1c.7 0 1.638-.23 2.437-.477a19.587 19.587 0 0 0 1.349-.476l.019-.007.004-.002h.001M14 1.221c-.22.078-.48.167-.766.255-.81.252-1.872.523-2.734.523-.886 0-1.592-.286-2.203-.534l-.008-.003C7.662 1.21 7.139 1 6.5 1c-.669 0-1.606.229-2.415.478A21.294 21.294 0 0 0 3 1.845v6.433c.22-.078.48-.167.766-.255C4.576 7.77 5.638 7.5 6.5 7.5c.847 0 1.548.28 2.158.525l.028.01C9.32 8.29 9.86 8.5 10.5 8.5c.668 0 1.606-.229 2.415-.478A21.317 21.317 0 0 0 14 7.655V1.222z" />
                        </svg>
                    </div>
                    <span class="w-full">Laporan Pembayaran</span>
                </div>
                @foreach ($laporanPembayaran as $order_code => $laporanGroup)
                    <div class="flex items-center gap-4 w-full">
                        <li class="my-3 w-full">{{ $order_code }} </li>
                        <a href="/history/{{ $order_code }}" target="_blank"
                            class="bg-green-300 p-3 rounded-md">Download</a>
                    </div>
                @endforeach
                <form action="{{ route('clearHistoryBuy') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-2 bg-red-400 rounded-md w-full mt-3">Hapus Pembayaran</button>
                </form>
                <div class="flex w-full bg-slate-300 border border-b-1"></div>

            </div>
        </div>
    </div>
@endsection
