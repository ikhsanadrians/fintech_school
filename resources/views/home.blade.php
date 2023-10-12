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
    <div class="container mx-auto">
        <div class="flex flex-col">
            <span class="text-xl ml-8 mb-4">Hello {{ $user->name }} welcome back👋</span>

            <div class="flex w-full">
                <div class="flex gap-4 flex-wrap ml-8 basis-[70%]">
                    @foreach ($products as $key => $product)
                        <div class="flex flex-col rounded-lg bg-gray-50 shadow-md basis-[30%] border border-slate-300">
                            <div class="flex bg-slate-200 p-10 rounded-t-lg">{{ $product->photo }}</div>
                            <div class="flex flex-col p-2">
                                <div class="flex flex-col">{{ $product->name }}</div>
                                <div class="flex">Rp.{{ $product->price }}</div>
                                <div class="flex">stock: {{ $product->stock }}</div>
                            </div>
                            <form action="{{ route('addToCart') }}" method="post">
                                @csrf
                                <div class="flex p-2">
                                    <input type="number" name="quantity" class="border border-black rounded-md w-full">
                                    <input type="hidden" name="products_id" value="{{ $product->id }}">
                                    <input type="hidden" name="price" value="{{ $product->price }}">
                                </div>
                                <div class="flex p-2">
                                    <button type="submit" class="p-2 bg-slate-200 rounded-lg w-full">Add to Cart</button>
                                </div>
                            </form>
                        </div>
                    @endforeach
                </div>
                <div class="flex flex-col basis-[25%]">
                    <div class="flex flex-col gap-3 border border-slate-300 rounded-xl p-4">
                        <span>keranjang</span>
                        @php
                            $totalPrice = 0;
                        @endphp
                        @foreach ($transactionsKeranjang as $ts)
                            <div class="flex items-center gap-2 w-full">
                                <li class="w-full">{{ $ts->products->name }} | {{ $ts->price }} | {{ $ts->quantity }}
                                </li>
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
                        <form action="{{ route('payProduct') }}" method="post" class="flex w-full mt-2">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="p-2 bg-slate-200 rounded-lg w-full">Buy</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
