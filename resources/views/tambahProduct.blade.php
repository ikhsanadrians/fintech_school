@extends('template.app_home')

@section('content')
    <div class="container mx-auto">
        <div class="flex flex-col w-full bg-white p-4 rounded-lg h-full">
            <span>Create Product</span>
            <form action="{{ route('storeProduct') }}" method="post" enctype="multipart/form-data" class="flex flex-col gap-4">
                @csrf
                <span>name</span>
                <input type="text" name="name" class="border">
                <span>price</span>
                <input type="number" name="price" class="border">
                <span>stock</span>
                <input type="number" name="stock" class="border">
                <span>photo</span>
                <input type="file" name="photo" class="border">
                <span>description</span>
                <input type="text" name="desc" class="border">
                <span>Category</span>
                <select name="categories_id">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <span>Stand</span>
                <input type="number" name="stand">
                <button type="submit">Create</button>
            </form>
        </div>
        <div class="flex h-20"></div>
    </div>
@endsection
