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
        <a href="/bank" class="hover:text-gray-300">Home</a>
    </li>
    <li class="flex items-center gap-3">
        <div class="flex flex-col items-center justify-center bg-slate-950 rounded-full p-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="fill-white"
                viewBox="0 0 16 16">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                <path
                    d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12z" />
            </svg>
        </div>
        <a href="/report-bank" class="hover:text-gray-300">Reports</a>
    </li>
@endsection

@section('content')
    <div class="container mx-auto">
        <div class="flex py-2 gap-3 mb-3">
            <div class="flex flex-col w-full bg-white p-4 rounded-lg h-full">
                <span class="text-2xl">Saldo</span>
                <span>{{ $difference_bank }}</span>
            </div>
            <div class="flex flex-col w-full bg-white p-4 rounded-lg h-full">
                <span class="text-2xl">Nasabah</span>
                <span>{{ $nasabah }}</span>
            </div>
            <div class="flex flex-col w-full bg-white p-4 rounded-lg h-full">
                <span class="text-2xl">Transaksi</span>
                <span>{{ $wallet_count }}</span>
            </div>
        </div>
        <div class="flex flex-col w-full bg-white p-4 rounded-lg h-full">
            <span class="text-2xl">List of expand</span>
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
