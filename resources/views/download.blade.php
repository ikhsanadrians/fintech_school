@extends('template.app')

@section('content')
    <div class="container mx-auto">
        @foreach ($report as $rp)
            <div class="flex items-center gap-4">
                <li class="my-3">{{ $rp->products->name }} | {{ $rp->price }} | {{ $rp->quantity }}</li>
            </div>
        @endforeach
    </div>
    <script>
        window.print()
    </script>
@endsection
