@extends('template.app_home')

@section('sidebar_features')
    <li class="flex items-center gap-3">
        <div class="flex flex-col items-center justify-center bg-slate-950 rounded-full p-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="fill-white"
                viewBox="0 0 16 16">
                <path
                    d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5ZM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5 5 5Z" />
            </svg>
        </div>
        <a href="/kantin" class="hover:text-gray-300">Home</a>
    </li>
    <li class="flex items-center gap-3">
        <div class="flex flex-col items-center justify-center bg-slate-950 rounded-full p-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="fill-white"
                viewBox="0 0 16 16">
                <path
                    d="M12.136.326A1.5 1.5 0 0 1 14 1.78V3h.5A1.5 1.5 0 0 1 16 4.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 13.5v-9a1.5 1.5 0 0 1 1.432-1.499L12.136.326zM5.562 3H13V1.78a.5.5 0 0 0-.621-.484L5.562 3zM1.5 4a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-13z" />
            </svg>
        </div>
        <a href="/transaction-kantin" class="hover:text-gray-300">Transactions</a>
    </li>
@endsection

@section('content')
    <div class="container mx-auto">
        <div class="flex flex-col w-full bg-white p-4 rounded-lg h-full">
            <span>Edit Product</span>
            <form action="/product-update/{{ $product->id }}" method="post" enctype="multipart/form-data"
                class="flex flex-col gap-4">
                @csrf
                @method('PUT')
                <span>name</span>
                <input type="text" name="name" class="border p-2" value="{{ $product->name }}">
                <div class="flex flex-col w-full">
                    <div class="flex w-full gap-4">
                        <div class="flex flex-col w-full">
                            <span>price</span>
                            <input type="number" name="price" class="border p-2" value="{{ $product->price }}">
                        </div>
                        <div class="flex flex-col w-full">
                            <span>Stand</span>
                            <input type="number" name="stand" value="{{ $product->stand }}" class="border p-2">
                        </div>
                    </div>
                    <div class="flex w-full gap-4">
                        <div class="flex flex-col w-full">
                            <span>stock</span>
                            <input type="number" name="stock" class="border p-2" value="{{ $product->stock }}">
                        </div>
                        <div class="flex flex-col w-full">
                            <span>Category</span>
                            <select name="categories_id" class="border p-2">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @if ($category->id == $product->category->id) selected @endif>
                                        {{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <span>photo</span>
                <img src="{{ $product->photo }}" alt="{{ $product->photo }}" class="object-cover w-20 h-20 rounded">
                <input type="file" name="photo" class="border" value="{{ $product->photo }}">
                <span>image link: {{ $product->photo }}</span>
                <span>description</span>
                <textarea type="text" name="desc" class="border p-2">{{ $product->desc }}</textarea>
                <button type="submit" class="bg-green-400 p-3 rounded-lg">Edit</button>
            </form>
        </div>
        <div class="flex h-20"></div>
    </div>
@endsection
