@extends('layouts.app')
    
@section('title', 'Persyaratan Layanan')

@section('content')
<div class="max-w-4xl mx-auto p-0 pb-20">
    <div class="bg-yellow/10 backdrop-blur-sm rounded-lg shadow-xl p-6 md:p-8">
        <a href="{{ url('/') }}" class="absolute top-4 left-4 text-gray-600 hover:text-blue-600 !important transition-colors duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
            </svg>
        </a>
        <div class="text-center mb-6">
            <div class="w-24 h-24 mx-auto mb-4">
                <img src="{{ asset('icon/syarat1.png') }}" alt="Ikon Layanan Online" class="w-full h-full object-contain">
            </div>
            <h2 class="text-3xl font-bold text-gray-800 text-center mb-2">Persyaratan</h2>
        </div>

        <!-- Alpine.js: Kelola state semua grup dan akordion -->

        <div
            x-data="{
                openGroup: null,
                openAccordion: {},
                toggleGroup(slug) {
                    this.openGroup = this.openGroup === slug ? null : slug;
                },
                toggleAccordion(slug) {
                    this.openAccordion[slug] = !this.openAccordion[slug];
                },
                isGroupOpen(slug) {
                    return this.openGroup === slug;
                },
                isAccordionOpen(slug) {
                    return this.openAccordion[slug] === true;
                }
            }"
            class="space-y-2"
        >
            @foreach($grouped as $keterangan => $items)
                @php
                    $groupSlug = Str::slug($keterangan);
                @endphp

                <div class="border border-white/50 rounded-xl overflow-hidden shadow-lg bg-white/50 backdrop-blur-sm">
                    <!-- Header Grup -->
                    <button
                        class="w-full flex justify-between items-center p-4 text-left hover:bg-blue-50 focus:outline-none transition-colors"
                        @click="toggleGroup('{{ $groupSlug }}')"
                        :aria-expanded="isGroupOpen('{{ $groupSlug }}')"
                    >
                        <span class="font-semibold text-gray-800 flex items-center gap-2">
                            {!! $items->icon_svg !!}
                            {{ $items->nama_lengkap }}
                        </span>
                        <svg
                            class="w-5 h-5 text-gray-600 transition-transform duration-200"
                            :class="{ 'rotate-180': isGroupOpen('{{ $groupSlug }}') }"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <!-- Daftar Akordion Anak -->
                    <div
                        x-show="isGroupOpen('{{ $groupSlug }}')"
                        x-collapse
                        class="px-4 pb-3 pt-2 bg-white/70 backdrop-blur-sm rounded-md"
                    >
                        @foreach($items as $index => $item)
                            @php
                                $accordionSlug = $groupSlug . '-' . $index;
                            @endphp

                            <div class="border-t border-gray-200 last:border-b">
                                <button
                                    class="w-full flex justify-between items-center p-3 text-left hover:bg-gray-50 focus:outline-none transition-colors"
                                    @click="toggleAccordion('{{ $accordionSlug }}')"
                                    :aria-expanded="isAccordionOpen('{{ $accordionSlug }}')"
                                >
                                    <span class="flex items-center gap-2 text-gray-800">
                                        @php
                                            $itemIcon = match(true) {
                                                default => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
  <path fill-rule="evenodd" d="M12.78 7.595a.75.75 0 0 1 0 1.06l-3.25 3.25a.75.75 0 0 1-1.06-1.06l2.72-2.72-2.72-2.72a.75.75 0 0 1 1.06-1.06l3.25 3.25Zm-8.25-3.25 3.25 3.25a.75.75 0 0 1 0 1.06l-3.25 3.25a.75.75 0 0 1-1.06-1.06l2.72-2.72-2.72-2.72a.75.75 0 0 1 1.06-1.06Z" clip-rule="evenodd" /></svg>',
                                            };
                                        @endphp
                                        {!! $itemIcon !!}
                                        {{ $item->nama }}
                                    </span>
                                    <svg
                                        class="w-5 h-5 text-gray-500 transition-transform duration-200"
                                        :class="{ 'rotate-180': isAccordionOpen('{{ $accordionSlug }}') }"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    >
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>

                                <!-- Konten Persyaratan -->
                                <div
                                    x-show="isAccordionOpen('{{ $accordionSlug }}')"
                                    x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0 scale-y-95"
                                    x-transition:enter-end="opacity-100 scale-y-100"
                                    x-transition:leave="transition ease-in duration-200"
                                    x-transition:leave-start="opacity-100 scale-y-100"
                                    x-transition:leave-end="opacity-0 scale-y-95"
                                    class="overflow-hidden px-4 pb-3 pt-2 bg-white/70 rounded-md origin-top"
                                    style="will-change: transform, opacity;"
                                >
                                    <ul class="space-y-2">
                                        @foreach($item->persyaratan_items as $syarat)
                                            @if(trim($syarat))
                                                <li class="flex items-start gap-2 py-2 border-b border-gray-100 last:border-b-0">
                                                    <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="text-gray-800 text-sm">{{ $syarat }}</span>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>                                        
</div>
@endsection
