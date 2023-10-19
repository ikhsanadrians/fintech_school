@extends('template.app_home')

@section('content')
    <div class="container mx-auto">
        <div class="flex flex-col w-full bg-white p-4 rounded-lg h-full">
            <span class="text-2xl">Hello, {{ $user->roles->name }} 👋</span>
            <div class="flex justify-between my-4">
                <div class="flex gap-2 items-center ">
                    <span class="text-lg text-slate-400">Filter By</span>
                    <select name="" id="" class="border rounded p-2 px-3">
                        <option value="">ascending</option>
                        <option value="">descending</option>
                    </select>
                </div>
                <div class="flex items-center gap-3 p-2 rounded bg-green-400">
                    <a href="/create-product" class="text-lg text-white">Add Product</a>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                        class="fill-white" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path
                            d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                    </svg>
                </div>
            </div>
            <div class="flex w-full">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="p-3">No</th>
                            <th class="p-3">Photo</th>
                            <th class="p-3">Name</th>
                            <th class="p-3">Category</th>
                            <th class="p-3">Price</th>
                            <th class="p-3">Stock</th>
                            <th class="p-3">Stand</th>
                            <th class="p-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $key => $product)
                            <tr class="border-b border-gray-200">
                                <td class="p-2 text-center">{{ $key + 1 }}</td>
                                <td class="p-2 flex justify-center">
                                    @if ($product->photo)
                                        <img src="{{ $product->photo }}" alt="none" class="object-cover rounded"
                                            width="100" height="100">
                                    @else
                                        <img src="{{ asset("photos/$product->name/photo.png") }}" alt="none"
                                            class="object-cover rounded" width="100" height="100">
                                    @endif
                                </td>
                                <td class="p-2 text-center">{{ $product->name }}</td>
                                <td class="p-2 text-center">{{ $product->category->name }}</td>
                                <td class="p-2 text-center">Rp {{ $product->price }}</td>
                                <td class="p-2 text-center">{{ $product->stock }}</td>
                                <td class="p-2 text-center">{{ $product->stand }}</td>
                                <td class="p-2 text-center">
                                    <a href="/delete" class="p-2 rounded border bg-red-400 text-white">Delete</a>
                                    <a href="/edit" class="p-2 rounded border bg-yellow-300 text-white">Edit</a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <div class="flex h-20"></div>
        </div>
    </div>
@endsection
