@extends('template.app')
@section('content')
    <div class="container mx-auto">
        <div class="flex flex-col gap-4">
            <span>dashboard</span>
            <a href="/login" class="p-4 bg-slate-200 rounded-lg w-20">Login</a>
            <a href="/register" class="p-4 bg-slate-200 rounded-lg w-20">Register</a>
        </div>
    </div>
@endsection
