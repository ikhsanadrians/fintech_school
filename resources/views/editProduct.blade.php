@extends('template.app_home')

@section('content')
    <div class="container mx-auto">
        <div class="flex flex-col w-full bg-white p-4 rounded-lg h-full">
            <span>Edit Product</span>
            <form action="{{ route('updateProduct') }}" method="post" enctype="multipart/form-data"
                class="flex flex-col gap-4">
                @csrf
                @method('PUT')
                <span>name</span>
                <input type="text" name="name" class="border" value="{{ $product->name }}">
                <span>price</span>
                <input type="number" name="price" class="border" value="{{ $product->price }}">
                <span>stock</span>
                <input type="number" name="stock" class="border" value="{{ $product->stock }}">
                <span>photo</span>
                <input type="file" name="photo" class="border" value="{{ $product->photo }}">
                <span>description</span>
                <input type="text" name="desc" class="border" value="{{ $product->desc }}">
                <span>Category</span>
                <select name="categories_id">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @if ($category->id == $product->category->id) selected @endif>
                            {{ $category->name }}</option>
                    @endforeach
                </select>
                <span>Stand</span>
                <input type="number" name="stand" value="{{ $product->stand }}">
                <button type="submit">Create</button>
            </form>
        </div>
        <div class="flex h-20"></div>
    </div>
@endsection
