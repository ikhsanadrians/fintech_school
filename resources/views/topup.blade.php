@extends('template.app_home')

@section('content')
    <div class="container mx-auto">
        <div class="flex flex-col w-full bg-white p-4 rounded-lg h-full">
            <span class="text-2xl">List of request top up</span>
            <div class="flex justify-between my-4">
                <div class="flex gap-2 items-center ">
                    <span class="text-lg text-slate-400">Filter By</span>
                    <select name="" id="" class="border rounded p-2 px-3">
                        <option value="">ascending</option>
                        <option value="">descending</option>
                    </select>
                </div>
            </div>
            <div class="flex w-full">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="p-3">No</th>
                            <th class="p-3">Name</th>
                            <th class="p-3">Credit</th>
                            <th class="p-3">Debit</th>
                            <th class="p-3">Status</th>
                            <th class="p-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($wallets as $key => $wallet)
                            <tr class="border-b border-gray-200">
                                <td class="text-center p-2">{{ $key + 1 }}</td>
                                <td class="text-center p-2">
                                    {{ $wallet->user->name }}
                                </td>
                                <td class="text-center p-2">
                                    {{ $wallet->credit ? $wallet->credit : '0' }}
                                </td>
                                <td class="text-center p-2">
                                    {{ $wallet->debit ? $wallet->debit : '0' }}
                                </td>
                                @if ($wallet->status == 'process')
                                    <td class="text-center p-2">
                                        <span class="p-2 bg-yellow-400">
                                            {{ $wallet->status }}
                                        </span>
                                    </td>
                                @else
                                    <td class="text-center p-2">
                                        <span class="p-2 bg-green-400">
                                            {{ $wallet->status }}
                                        </span>
                                    </td>
                                @endif

                                @if ($wallet->status == 'selesai')
                                    <td class="text-center p-3">
                                        <span class="bg-green-400 p-2 rounded">OK</span>
                                    </td>
                                @else
                                    <td class="text-center p-2">
                                        <form action="/topup/{{ $wallet->id }}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="bg-sky-400 p-2 rounded">Accept</button>
                                        </form>
                                    </td>
                                @endif

                    </tbody>
                    @endforeach
                </table>
            </div>
        </div>


    </div>
@endsection
