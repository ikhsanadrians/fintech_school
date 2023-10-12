@extends('template.app_home')

@section('content')
    <div class="container mx-auto">
        <div class="flex mt-4">
            <div class="flex gap-4 flex-wrap ml-8 basis-[70%]">
                @foreach ($clots as $clot)
                    @foreach ($clot->products as $cl)
                        <div class="flex flex-col rounded-lg bg-gray-50 shadow-md basis-[30%] border border-slate-300">
                            <div class="flex bg-slate-200 p-10 rounded-t-lg">{{ $cl->photo }}</div>
                            <div class="flex flex-col p-2">
                                <div class="flex flex-col"><a href="/product/{{ $cl->id }}">{{ $cl->name }}</a>
                                </div>
                                <div class="flex">Rp.{{ $cl->price }}</div>
                                <div class="flex">stock: {{ $cl->stock }}</div>
                            </div>
                            <form action="{{ route('addToCart') }}" method="post">
                                @csrf
                                <div class="flex p-2">
                                    <input type="number" name="quantity" class="border border-black rounded-md w-full">
                                    <input type="hidden" name="products_id" value="{{ $cl->id }}">
                                    <input type="hidden" name="price" value="{{ $cl->price }}">
                                </div>
                                <div class="flex p-2">
                                    <button type="submit" class="p-2 bg-slate-200 rounded-lg w-full">Add to Cart</button>
                                </div>
                            </form>
                        </div>
                    @endforeach
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
@endsection
