@extends('layouts.app')
@section('content')

<div class="min-h-screen pt-0 flex items-start justify-center">
    <div class="max-w-5xl mx-auto p-4 pb-20">

        <div class="bg-yellow/10 backdrop-blur-sm rounded-lg shadow-xl p-6 md:p-8">
            <a href="{{ url('/') }}" class="absolute top-4 left-4 text-gray-600 hover:text-blue-600 !important transition-colors duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
                </svg>
            </a>
            <div class="w-24 h-24 mx-auto mb-4">
                <img src="{{ asset('icon/online.png') }}" alt="Formulir" class="w-full h-full object-contain">
            </div>
            
            <h1 class="text-3xl font-bold text-gray-800 text-center mb-6">Daftar Formulir</h1>
            <table class="w-full border-collapse text-gray-700">
                <thead class="bg-gray-200 !important font-semibold">
                    <tr>
                        <th class="py-2 px-3 border-b border-gray-300 text-left">No</th>
                        <th class="py-2 px-3 border-b border-gray-300 text-left">Jenis Formulir</th>
                        <th class="py-2 px-3 border-b border-gray-300 text-left">Keterangan</th>
                        <th class="py-2 px-3 border-b border-gray-300 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($formulirs as $index => $formulir)
                    <tr class="hover:bg-gray-100 transition-colors duration-200">
                        <td class="py-2 px-3 border-b border-gray-300">{{ $index + 1 }}</td>
                        <td class="py-2 px-3 border-b border-gray-300">{{ $formulir->jenis_formulir }}</td>
                        <td class="py-2 px-3 border-b border-gray-300">{{ $formulir->ket }}</td>
                        <td class="py-2 px-3 border-b border-gray-300">
                            <a href="{{ route('formulir.download', $formulir->dokumen) }}" class="text-blue-600 hover:text-blue-800 font-semibold">Unduh</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-8 flex justify-center gap-4">
                {{-- <a href="{{ url('/') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow transition-colors duration-200">
                    Kembali
                </a> --}}
            </div>
        </div>
    </div>
</div>
@endsection