@extends('template.app')

@section('content')
    <div class="container mx-auto">
        <div class="flex flex-col">
            <span>berhasil login {{ $user->name }} as a {{ $user->roles->name }}</span>
            <span>saldo: {{ $difference }}</span>

            <div class="flex w-full">
                <div class="flex gap-6">
                    @foreach ($products as $key => $product)
                        <div class="flex flex-col rounded-lg bg-gray-50 shadow-lg">
                            <div class="flex bg-slate-200 p-10 rounded-t-lg">{{ $product->photo }}</div>
                            <div class="flex flex-col p-2">
                                <div class="flex flex-col">{{ $product->name }}</div>
                                <div class="flex">{{ $product->desc }}</div>
                                <div class="flex">price: Rp{{ $product->price }}</div>
                                <div class="flex">stock: {{ $product->stock }}</div>
                            </div>
                            <form action="{{ route('addToCart') }}" method="post">
                                @csrf
                                <div class="flex p-2">
                                    <input type="number" name="quantity" class="border border-black rounded-md">
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
                <div class="flex flex-col">
                    <div class="flex flex-col">
                        <span>keranjang</span>
                        @php
                            $totalPrice = 0;
                        @endphp
                        @foreach ($transactionsKeranjang as $ts)
                            <li>{{ $ts->products->name }} | {{ $ts->price }} | {{ $ts->quantity }}</li>
                            <li>{{ $ts->order_code }}</li>
                            <ul>status: {{ $ts->status }}</ul>
                            @php
                                $totalPrice += $ts->price * $ts->quantity;
                            @endphp
                        @endforeach
                        <p>total harga: {{ $totalPrice }}</p>
                        <div class="flex p-2">
                            <form action="{{ route('payProduct') }}" method="post">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="p-2 bg-slate-200 rounded-lg w-full">Buy</button>
                            </form>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <span>dibayar</span>
                        @foreach ($transactionsBayar as $ts)
                            <li>{{ $ts->products->name }} | {{ $ts->price }} | {{ $ts->quantity }}</li>
                            <ul>status: {{ $ts->status }}</ul>
                        @endforeach

                    </div>
                </div>
            </div>


            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button type="submit" class="p-4 bg-slate-200 rounded-lg">Logout</button>
            </form>
        </div>

    </div>
@endsection
