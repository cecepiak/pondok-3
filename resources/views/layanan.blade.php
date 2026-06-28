@extends('layouts.app')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="text-center mb-8">
        <div class="w-24 h-24 mx-auto mb-4">
            <img src="{{ asset('icon/logo4.png') }}" alt="Ikon Layanan Online" class="w-full h-full object-contain">
        </div>
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Perhatian</h1>
        <p class="text-sm text-gray-600">Silahkan klik tombol <strong>Informasi</strong> di setiap layanan yang dipilih, agar dapat memahami detail layanannya. Siapkan <strong>foto(asli)</strong> persyaratan, dan semua <strong>wajib</strong> dilengkapi.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 -m-2">
        {{-- KTP --}}
        <div class="p-2 fade-in-card">
            <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-500 ease-out border-2 border-transparent hover:shadow-xl hover:scale-[1.02] hover:border-blue-500 cursor-pointer h-full">
                <div class="bg-blue-50 p-6 flex justify-center">
                    <img src="{{ asset('icon/ktp.png') }}" alt="KTP-EL" class="w-32 h-32 object-contain">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">KTP-EL</h3>
                    <p class="text-gray-600 text-sm mb-4">Pengajuan KTP-El karena hilang, rusak, atau perubahan data</p>
                    <div class="flex space-x-2">
                        @guest
                            <button type="button"
                                onclick="event.preventDefault(); event.stopPropagation(); showPanduanRich(
                                    'Layanan Kartu Tanda Penduduk',
                                    `
                                    <div class='p-0 sm:p-1 text-gray-700 rounded-lg text-xs sm:text-sm leading-relaxed' style='text-align: left !important'>
                                        <div class='flex flex-col items-center mb-4'>
                                            <svg xmlns='http://www.w3.org/2000/svg' width='48' height='48' viewBox='0 0 24 24' fill='none' stroke='#3B82F6' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'>
                                                <rect x='3' y='5' width='18' height='14' rx='2'/>
                                                <path d='M8 10h4'/>
                                                <path d='M8 14h6'/>
                                                <circle cx='17' cy='12' r='1'/>
                                            </svg>
                                            <h3 class='mt-2 text-lg font-bold text-blue-500'>Layanan KTP-EL</h3>
                                        </div>
                                        <p>KTP elektronik (KTP-el) merupakan identitas resmi penduduk Indonesia yang berbasis teknologi chip untuk menyimpan data kependudukan secara digital. Disdukcapil Tapin menyediakan layanan terkait KTP-el diantaranya penerbitan KTP-el baru bagi penduduk yang telah berusia 17 tahun atau sudah menikah, penggantian KTP-el karena hilang atau rusak, dan perubahan data KTP-el.</p><br>
                                        <p>Sebelum melakukan pengajuan permohonan, pastikan Anda telah menyiapkan lampiran foto berkas pendukung asli yang dibutuhkan (bukan fotocopy) dan pastikan foto berkas dapat terbaca dengan jelas.</p>
                                        <br>
                                        <ul class='list-disc pl-5 space-y-1 mt-2'>
                                            <li><strong>Pengajuan Baru</strong>: Lampirkan foto bukti perekaman.</li>
                                            <li><strong>Hilang</strong>: Lampirkan foto surat kehilangan dari kepolisian.</li>
                                            <li><strong>Rusak</strong>: Lampirkan foto KTP yang rusak.</li>
                                            <li><strong>Perubahan Data</strong>: Lampirkan foto KK baru yang sudah diperbarui. Data pada KTP mengikuti data pada KK. Sebelum mengajukan perubahan data KTP, pastikan data KK sudah sesuai dengan data terbaru. Golongan Darah : Lampirkan foto KK terbaru yang ada golongan darah, atau KTP lama yang sudah ada golongan darah. Golongan darah akan muncul jika di data KK sudah ada golongan darah. Jika KK belum ada golongan darah dan ingin menambahkan golongan darah pada KTP, ubah terlebih dahulu KK melalui menu Kartu Keluarga.</li>
                                        </ul>
                                        <br>
                                        <p>Selengkapnya lihat <a href='https://dukcapil.tapinkab.go.id/pelayanan/ktp-elektronik' target='_blank' class='text-blue-600 underline'>disini</a>.</p>
                                    </div>
                                    <div class='mt-4 pt-3 border-t border-gray-200'></div>
                                    <div class='bg-gray-100 py-4 px-4 sm:px-4 rounded-md'>
                                        <div class='flex justify-between gap-2 fade-in-card'>
                                            <button type='button' class='btn-masuk flex-1 px-4 py-2 h-10 bg-green-600 text-white font-medium rounded-sm hover:bg-green-700 focus:outline-none'>Masuk</button>
                                            <button type='button' class='btn-daftar flex-1 px-4 py-2 h-10 bg-blue-600 text-white font-medium rounded-sm hover:bg-blue-700 focus:outline-none'>Daftar</button>
                                        </div>
                                    </div>
                                    `,
                                    '/form_pengajuan?keterangan=KTP&judul=Kartu%20Tanda%20Penduduk&icon=ktp.png',
                                    '/login',
                                    '/register'
                                )"
                                class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 text-xs font-medium rounded-md hover:bg-blue-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Informasi
                            </button>
                            <button type="button"
                                onclick="event.preventDefault(); event.stopPropagation(); cekStatusTransaksi();"
                                class="px-4 py-2 bg-blue-600 text-white text-xs font-medium rounded-md hover:bg-blue-700">
                                Status
                            </button>
                        @else
                            <a href="/form_pengajuan?keterangan=KTP&judul=KTP-Elektronik"
                                class="inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white text-xs font-medium rounded-md hover:bg-green-700 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Ajukan Permohonan
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>

        {{-- Kartu Keluarga --}}
        <div class="p-2 fade-in-card">
            <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-500 ease-out border-2 border-transparent hover:shadow-xl hover:scale-[1.02] hover:border-blue-500 cursor-pointer h-full">
                <div class="bg-blue-50 p-6 flex justify-center">
                    <img src="{{ asset('icon/kk.png') }}" alt="Kartu Keluarga" class="w-32 h-32 object-contain">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Kartu Keluarga</h3>
                    <p class="text-gray-600 text-sm mb-4">Pengajuan perubahan data di Kartu Keluarga</p>
                    <div class="flex space-x-2">
                        @guest
                            <button type="button"
                                onclick="event.preventDefault(); event.stopPropagation(); showPanduanRich(
                                    'Layanan Kartu Keluarga',
                                    `
                                    <div class='p-0 sm:p-1 text-gray-700 rounded-lg text-xs sm:text-sm leading-relaxed' style='text-align: left !important'>
                                        <div class='flex flex-col items-center mb-4'>
                                            <svg xmlns='http://www.w3.org/2000/svg' width='48' height='48' viewBox='0 0 24 24' fill='none' stroke='#3B82F6' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'>
                                                <path d='m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z'/>
                                                <path d='M10 13a2 2 0 1 0 4 0'/>
                                                <path d='M10 22v-4a2 2 0 0 1 2-2h0a2 2 0 0 1 2 2v4'/>
                                            </svg>
                                            <h3 class='mt-2 text-lg font-bold text-blue-500'>Layanan Kartu Keluarga</h3>
                                        </div>
                                        <p>Layanan Kartu Keluarga dapat digunakan dalam pembaruan, perubahan data, dan pencetakan kartu keluarga sebagai dokumen resmi yang memuat data anggota keluarga.</p>
                                        <br>
                                        <p>Pastikan Anda telah menyiapkan lampiran foto berkas pendukung asli yang dibutuhkan (bukan fotocopy) dan pastikan foto berkas dapat terbaca dengan jelas.</p>
                                        <ul class='list-disc pl-5 space-y-1 mt-2'>
                                            <li><strong>Perubahan Data</strong> : Melampirkan foto bukti pendukung asli berwarna dan Formulir Perubahan Data (F-1.06).</li>
                                            <li><strong>Hilang</strong> : Melampirkan foto surat kehilangan dari Kepolisian.</li>
                                            <li><strong>Rusak</strong> : Melampirkan foto KK yang rusak.</li>
                                        </ul>
                                        <br>
                                        <p>Selengkapnya mengenai tata cara dan persyaratan pengajuan layanan Kartu Keluarga, dapat dilihat <a href='https://dukcapil.tapinkab.go.id/pelayanan/kartu-keluarga' target='_blank' class='text-blue-600 underline'>disini</a>.</p>
                                        <br>
                                        <p>Silahkan masuk atau daftar aplikasi untuk melanjutkan proses pengajuan permohonan administrasi kependudukan. Semua formulir kependudukan dapat diunduh <a href='https://pondok.dukcapil.tapinkab.go.id/formulir' target='_blank' class='text-blue-600 underline'>disini</a>.</p>
                                    </div>
                                    <div class='mt-4 pt-3 border-t border-gray-200'></div>
                                    <div class='bg-gray-100 py-4 px-4 sm:px-4 rounded-md'>
                                        <div class='flex justify-between gap-2 fade-in-card'>
                                            <button type='button' class='btn-masuk flex-1 px-4 py-2 h-10 bg-green-600 text-white font-medium rounded-sm hover:bg-green-700 focus:outline-none'>Masuk</button>
                                            <button type='button' class='btn-daftar flex-1 px-4 py-2 h-10 bg-blue-600 text-white font-medium rounded-sm hover:bg-blue-700 focus:outline-none'>Daftar</button>
                                        </div>
                                    </div>
                                    `,
                                    '/form_pengajuan?keterangan=KK&judul=Kartu%20Keluarga&icon=kk.png',
                                    '/login',
                                    '/register'
                                )"
                                class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 text-xs font-medium rounded-md hover:bg-blue-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Informasi
                            </button>
                            <button type="button"
                                onclick="event.preventDefault(); event.stopPropagation(); cekStatusTransaksi();"
                                class="px-4 py-2 bg-blue-600 text-white text-xs font-medium rounded-md hover:bg-blue-700">
                                Status
                            </button>
                        @else
                            <a href="/form_pengajuan?keterangan=KK&judul=Kartu%20Keluarga&icon=kk.png"
                                class="inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white text-xs font-medium rounded-md hover:bg-green-700 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Ajukan Permohonan
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>

        {{-- KIA --}}
        <div class="p-2 fade-in-card">
            <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-500 ease-out border-2 border-transparent hover:shadow-xl hover:scale-[1.02] hover:border-blue-500 cursor-pointer h-full">
                <div class="bg-blue-50 p-6 flex justify-center">
                    <img src="{{ asset('icon/kia.png') }}" alt="Kartu Identitas Anak" class="w-32 h-32 object-contain">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">KIA</h3>
                    <p class="text-gray-600 text-sm mb-4">Pengajuan KIA baru, hilang, perubahan, atau rusak</p>
                    <div class="flex space-x-2">
                        @guest
                            <button type="button"
                                onclick="event.preventDefault(); event.stopPropagation(); showPanduanRich(
                                    'Layanan Kartu Identitas Anak',
                                    `
                                    <div class='p-0 sm:p-1 text-gray-700 rounded-lg text-xs sm:text-sm leading-relaxed' style='text-align: left !important'>
                                        <div class='flex flex-col items-center mb-4'>
                                            <svg xmlns='http://www.w3.org/2000/svg' width='48' height='48' viewBox='0 0 24 24' fill='none' stroke='#3B82F6' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'>
                                                <rect x='3' y='5' width='18' height='14' rx='2'/>
                                                <circle cx='10' cy='12' r='1.5'/>
                                                <path d='M13 14c1.1 0 2-.9 2-2s-.9-2-2-2'/>
                                                <path d='M17 10h-2'/>
                                            </svg>
                                            <h3 class='mt-2 text-lg font-bold text-blue-500'>Layanan Kartu Identitas Anak</h3>
                                        </div>
                                        <p>Layanan Kartu Identitas Anak (KIA) bertujuan untuk menyediakan dokumen identitas resmi bagi anak-anak berusia 0 hingga 16 tahun yang belum memiliki KTP. Layanan mencakup pembuatan KIA baru, penggantian KIA yang hilang atau rusak, serta pembaruan data sesuai perubahan identitas anak.</p>
                                        <br>
                                        <p>Pastikan Anda telah menyiapkan lampiran foto berkas pendukung asli yang dibutuhkan (bukan fotocopy) dan pastikan foto berkas dapat terbaca dengan jelas.</p>
                                        <ul class='list-disc pl-5 space-y-1 mt-2'>
                                            <li><strong>Perubahan Data</strong> : Melampirkan foto bukti pendukung asli berwarna dan Formulir Perubahan Data (F-1.06).</li>
                                            <li><strong>Perpanjangan KIA</strong> : Melampirkan foto KIA lama.</li>
                                            <li><strong>Hilang</strong> : Melampirkan foto surat kehilangan dari Kepolisian.</li>
                                            <li><strong>Rusak</strong> : Melampirkan foto KIA yang rusak.</li>
                                        </ul>
                                        <br>
                                        <p>Selengkapnya mengenai tata cara dan persyaratan pengajuan layanan KIA, dapat dilihat <a href='https://dukcapil.tapinkab.go.id/pelayanan/kartu-identitas-anak' target='_blank' class='text-blue-600 underline'>disini</a>.</p>
                                        <br>
                                        <p>Silahkan masuk atau daftar aplikasi untuk melanjutkan proses pengajuan permohonan administrasi kependudukan. Semua formulir kependudukan dapat diunduh <a href='https://pondok.dukcapil.tapinkab.go.id/formulir' target='_blank' class='text-blue-600 underline'>disini</a>.</p>
                                    </div>
                                    <div class='mt-4 pt-3 border-t border-gray-200'></div>
                                    <div class='bg-gray-100 py-4 px-4 sm:px-4 rounded-md'>
                                        <div class='flex justify-between gap-2 fade-in-card'>
                                            <button type='button' class='btn-masuk flex-1 px-4 py-2 h-10 bg-green-600 text-white font-medium rounded-sm hover:bg-green-700 focus:outline-none'>Masuk</button>
                                            <button type='button' class='btn-daftar flex-1 px-4 py-2 h-10 bg-blue-600 text-white font-medium rounded-sm hover:bg-blue-700 focus:outline-none'>Daftar</button>
                                        </div>
                                    </div>
                                    `,
                                    '/form_pengajuan?keterangan=KIA&judul=Kartu%20Identitas%20Anak&icon=kia.png',
                                    '/login',
                                    '/register'
                                )"
                                class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 text-xs font-medium rounded-md hover:bg-blue-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Informasi
                            </button>
                            <button type="button"
                                onclick="event.preventDefault(); event.stopPropagation(); cekStatusTransaksi();"
                                class="px-4 py-2 bg-blue-600 text-white text-xs font-medium rounded-md hover:bg-blue-700">
                                Status
                            </button>
                        @else
                            <a href="/form_pengajuan?keterangan=KIA&judul=Kartu%20Identitas%20Anak&icon=kia.png"
                                class="inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white text-xs font-medium rounded-md hover:bg-green-700 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Ajukan Permohonan
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>

        {{-- Akta Kelahiran --}}
        <div class="p-2 fade-in-card">
            <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-500 ease-out border-2 border-transparent hover:shadow-xl hover:scale-[1.02] hover:border-blue-500 cursor-pointer h-full">
                <div class="bg-blue-50 p-6 flex justify-center">
                    <img src="{{ asset('icon/akta-kelahiran.png') }}" alt="Akta Kelahiran" class="w-32 h-32 object-contain">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Akta Kelahiran</h3>
                    <p class="text-gray-600 text-sm mb-4">Pengajuan Akta kelahiran baru, hilang, perubahan, atau rusak</p>
                    <div class="flex space-x-2">
                        @guest
                            <button type="button"
                                onclick="event.preventDefault(); event.stopPropagation(); showPanduanRich(
                                    'Layanan Akta Kelahiran',
                                    `
                                    <div class='p-0 sm:p-1 text-gray-700 rounded-lg text-xs sm:text-sm leading-relaxed' style='text-align: left !important'>
                                        <div class='flex flex-col items-center mb-4'>
                                            <svg xmlns='http://www.w3.org/2000/svg' width='48' height='48' viewBox='0 0 24 24' fill='none' stroke='#3B82F6' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'>
                                                <path d='M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z'/>
                                                <path d='M14 2v6h6'/>
                                                <path d='M12 11v6'/>
                                                <path d='M9 14h6'/>
                                            </svg>
                                            <h3 class='mt-2 text-lg font-bold text-blue-500'>Layanan Akta Kelahiran</h3>
                                        </div>
                                        <p>Layanan Akta Kelahiran menyediakan dokumen legal yang mencatat kelahiran seseorang sebagai bentuk pengakuan resmi dari pemerintah. Akta kelahiran merupakan dokumen dasar dalam administrasi kependudukan yang penting untuk berbagai keperluan, seperti pendidikan, kesehatan, pekerjaan, dan perjalanan. Akta Kelahiran dirancang untuk memastikan hak identitas setiap warga negara tercatat dan diakui secara sah.</p>
                                        <br>
                                        <p>Pastikan Anda telah menyiapkan lampiran foto berkas pendukung asli yang dibutuhkan (bukan fotocopy) dan pastikan foto berkas dapat terbaca dengan jelas.</p>
                                        <ul class='list-disc pl-5 space-y-1 mt-2'>
                                            <li><strong>Pengajuan Akta Kelahiran</strong> : Melampirkan foto bukti pendukung asli berwarna.</li>
                                            <li><strong>Perubahan Data Akta</strong> : Melampirkan foto bukti pendukung asli berwarna dan Formulir Perubahan Data (F-1.06).</li>
                                            <li><strong>Hilang</strong> : Melampirkan foto surat kehilangan dari Kepolisian.</li>
                                            <li><strong>Rusak</strong> : Melampirkan foto Akta yang rusak.</li>
                                        </ul>
                                        <br>
                                        <p>Selengkapnya mengenai tata cara dan persyaratan pengajuan layanan Akta Kelahiran, dapat dilihat <a href='https://dukcapil.tapinkab.go.id/pelayanan/akta-kelahiran' target='_blank' class='text-blue-600 underline'>disini</a>.</p>
                                        <br>
                                        <p>Silahkan masuk atau daftar aplikasi untuk melanjutkan proses pengajuan permohonan administrasi kependudukan. Semua formulir kependudukan dapat diunduh <a href='https://pondok.dukcapil.tapinkab.go.id/formulir' target='_blank' class='text-blue-600 underline'>disini</a>.</p>
                                    </div>
                                    <div class='mt-4 pt-3 border-t border-gray-200'></div>
                                    <div class='bg-gray-100 py-4 px-4 sm:px-4 rounded-md'>
                                        <div class='flex justify-between gap-2 fade-in-card'>
                                            <button type='button' class='btn-masuk flex-1 px-4 py-2 h-10 bg-green-600 text-white font-medium rounded-sm hover:bg-green-700 focus:outline-none'>Masuk</button>
                                            <button type='button' class='btn-daftar flex-1 px-4 py-2 h-10 bg-blue-600 text-white font-medium rounded-sm hover:bg-blue-700 focus:outline-none'>Daftar</button>
                                        </div>
                                    </div>
                                    `,
                                    '/form_pengajuan?keterangan=ALH&judul=Akta%20Kelahiran&icon=akta-kelahiran.png',
                                    '/login',
                                    '/register'
                                )"
                                class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 text-xs font-medium rounded-md hover:bg-blue-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Informasi
                            </button>
                            <button type="button"
                                onclick="event.preventDefault(); event.stopPropagation(); cekStatusTransaksi();"
                                class="px-4 py-2 bg-blue-600 text-white text-xs font-medium rounded-md hover:bg-blue-700">
                                Status
                            </button>
                        @else
                            <a href="/form_pengajuan?keterangan=ALH&judul=Akta%20Kelahiran&icon=akta-kelahiran.png"
                                class="inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white text-xs font-medium rounded-md hover:bg-green-700 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Ajukan Permohonan
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>

        {{-- Akta Kematian --}}
        <div class="p-2 fade-in-card">
            <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-500 ease-out border-2 border-transparent hover:shadow-xl hover:scale-[1.02] hover:border-blue-500 cursor-pointer h-full">
                <div class="bg-blue-50 p-6 flex justify-center">
                    <img src="{{ asset('icon/akta-kematian.png') }}" alt="Akta Kematian" class="w-32 h-32 object-contain">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Akta Kematian</h3>
                    <p class="text-gray-600 text-sm mb-4">Pengajuan Akta kematian baru, hilang, perubahan, atau rusak</p>
                    <div class="flex space-x-2">
                        @guest
                            <button type="button"
                                onclick="event.preventDefault(); event.stopPropagation(); showPanduanRich(
                                    'Layanan Akta Kematian',
                                    `
                                    <div class='p-0 sm:p-1 text-gray-700 rounded-lg text-xs sm:text-sm leading-relaxed' style='text-align: left !important'>
                                        <div class='flex flex-col items-center mb-4'>
                                            <svg xmlns='http://www.w3.org/2000/svg' width='48' height='48' viewBox='0 0 24 24' fill='none' stroke='#3B82F6' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'>
                                                <path d='M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z'/>
                                                <path d='M14 2v6h6'/>
                                                <path d='M8 15h8'/>
                                            </svg>
                                            <h3 class='mt-2 text-lg font-bold text-blue-500'>Layanan Akta Kematian</h3>
                                        </div>
                                        <p>Layanan akta kematian adalah proses administratif yang bertujuan untuk mencatat dan mengesahkan kematian seseorang oleh pihak berwenang. Akta kematian digunakan sebagai bukti sah atas kematian seseorang untuk berbagai keperluan hukum dan administratif.</p>
                                        <br>
                                        <p>Pastikan Anda telah menyiapkan lampiran foto berkas pendukung asli yang dibutuhkan (bukan fotocopy) dan pastikan foto berkas dapat terbaca dengan jelas.</p>
                                        <ul class='list-disc pl-5 space-y-1 mt-2'>
                                            <li><strong>Pengajuan Akta Kematian</strong> : Melampirkan foto bukti pendukung asli berwarna.</li>
                                            <li><strong>Hilang</strong> : Melampirkan foto surat kehilangan dari Kepolisian.</li>
                                            <li><strong>Rusak</strong> : Melampirkan foto Akta Kematian yang rusak.</li>
                                        </ul>
                                        <br>
                                        <p>Selengkapnya mengenai tata cara dan persyaratan pengajuan layanan Akta Kematian, dapat dilihat <a href='https://dukcapil.tapinkab.go.id/pelayanan/akta-kematian' target='_blank' class='text-blue-600 underline'>disini</a>.</p>
                                        <br>
                                        <p>Silahkan masuk atau daftar aplikasi untuk melanjutkan proses pengajuan permohonan administrasi kependudukan. Semua formulir kependudukan dapat diunduh <a href='https://pondok.dukcapil.tapinkab.go.id/formulir' target='_blank' class='text-blue-600 underline'>disini</a>.</p>
                                    </div>
                                    <div class='mt-4 pt-3 border-t border-gray-200'></div>
                                    <div class='bg-gray-100 py-4 px-4 sm:px-4 rounded-md'>
                                        <div class='flex justify-between gap-2 fade-in-card'>
                                            <button type='button' class='btn-masuk flex-1 px-4 py-2 h-10 bg-green-600 text-white font-medium rounded-sm hover:bg-green-700 focus:outline-none'>Masuk</button>
                                            <button type='button' class='btn-daftar flex-1 px-4 py-2 h-10 bg-blue-600 text-white font-medium rounded-sm hover:bg-blue-700 focus:outline-none'>Daftar</button>
                                        </div>
                                    </div>
                                    `,
                                    '/form_pengajuan?keterangan=AMT&judul=Akta%20Kematian&icon=akta-kematian.png',
                                    '/login',
                                    '/register'
                                )"
                                class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 text-xs font-medium rounded-md hover:bg-blue-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Informasi
                            </button>
                            <button type="button"
                                onclick="event.preventDefault(); event.stopPropagation(); cekStatusTransaksi();"
                                class="px-4 py-2 bg-blue-600 text-white text-xs font-medium rounded-md hover:bg-blue-700">
                                Status
                            </button>
                        @else
                            <a href="/form_pengajuan?keterangan=AMT&judul=Akta%20Kematian&icon=akta-kematian.png"
                                class="inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white text-xs font-medium rounded-md hover:bg-green-700 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Ajukan Permohonan
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>

        {{-- Kedatangan Penduduk --}}
        <div class="p-2 fade-in-card">
            <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-500 ease-out border-2 border-transparent hover:shadow-xl hover:scale-[1.02] hover:border-blue-500 cursor-pointer h-full">
                <div class="bg-blue-50 p-6 flex justify-center">
                    <img src="{{ asset('icon/kedatangan.png') }}" alt="Pindah Datang" class="w-32 h-32 object-contain">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Pindah Datang</h3>
                    <p class="text-gray-600 text-sm mb-4">Pengajuan menjadi warga Tapin dengan melampirkan SKPWNI</p>
                    <div class="flex space-x-2">
                        @guest
                            <button type="button"
                                onclick="event.preventDefault(); event.stopPropagation(); showPanduanRich(
                                    'Layanan Kedatangan Penduduk',
                                    `
                                    <div class='p-0 sm:p-1 text-gray-700 rounded-lg text-xs sm:text-sm leading-relaxed' style='text-align: left !important'>
                                        <div class='flex flex-col items-center mb-4'>
                                            <svg xmlns='http://www.w3.org/2000/svg' width='48' height='48' viewBox='0 0 24 24' fill='none' stroke='#3B82F6' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'>
                                                <rect x='4' y='12' width='16' height='5' rx='1'/>
                                                <path d='M6 12V9h12v3'/>
                                                <circle cx='7' cy='19' r='1.5'/>
                                                <circle cx='17' cy='19' r='1.5'/>
                                                <path d='M18 6H6'/>
                                                <path d='M8 4l-2 2 2 2'/>
                                            </svg>
                                            <h3 class='mt-2 text-lg font-bold text-blue-500'>Persyaratan Pindah Masuk Tapin</h3>
                                        </div>
                                        <p class='font-bold text-orange-500'>A. KK ANGGOTA SENDIRI ATAU SATU KELUARGA</p>
                                        <ul class='list-disc pl-5 space-y-0 mt-1'>
                                            <li>Foto asli surat pindah/SKPWNI dari Dukcapil asal;</li>
                                            <li>Foto semua KTP lama asli;</li>
                                            <li>Foto asli Surat pernyataan tempat tinggal di Tapin bermaterai terbaru Rp.10,000 dan ditandatangani ybs, ditandatangani RT dan di beri cap RT (jika kost/kontrak/numpang alamat yang bertandatangan pemilik alamat tempat tinggal);</li>
                                            <li>Foto asli form F-1.06 perubahan elemen data dan dokumen pendukung asli perubahan data jika ada perubahan data, misal: perubahan pendidikan, pekerjaan, agama, dll contoh: pendidikan terakhir semua SLTP/Sederajat menjadi S1, maka melampirkan foto asli IJAZAH S1.</li>
                                        </ul>
                                        <br>
                                        <p class='font-bold text-orange-500'>B. PINDAH NUMPANG KK</p>
                                        <ul class='list-disc pl-5 space-y-0 mt-1'>
                                            <li>Foto asli surat pindah/SKPWNI dari Dukcapil asal;</li>
                                            <li>Foto semua KTP lama asli yang pindah;</li>
                                            <li>Foto asli KK yang akan di tumpangi, sudah ditandatangani oleh Kepala Keluarga;</li>
                                            <li>Surat Pernyataan numpang KK yang ditandatangani oleh Kepala Keluarga bermaterai dan ditandatangani (jika anak kandung tidak perlu dilampirkan);</li>
                                            <li>Foto asli form F-1.06 perubahan elemen data dan dokumen pendukung asli perubahan data jika ada perubahan data, misal: perubahan pendidikan, pekerjaan, agama, dll contoh: pendidikan terakhir semua SLTP/Sederajat menjadi S1, maka melampirkan foto asli IJAZAH S1.</li>
                                        </ul>
                                        <br>
                                        <p class='font-bold text-orange-500'>C. PINDAH MEMBUAT KK KARENA MENIKAH/SUAMI ISTRI</p>
                                        <ul class='font-bold pl-4 space-y-0 mt-1'>1. KEDUA PASANGAN DENGAN ALAMAT LUAR TAPIN</ul>
                                        <ul class='list-disc pl-12 space-y-0 mt-1'>
                                            <li>Foto asli surat pindah/SKPWNI suami dan istri dari Dukcapil asal;</li>
                                            <li>Foto KTP lama asli yang pindah;</li>
                                            <li>Foto asli Surat pernyataan tempat tinggal di Tapin bermaterai terbaru Rp.10,000 dan ditandatangani ybs, ditandatangani RT dan di beri cap RT (jika kost/kontrak/numpang alamat yang bertandatangan pemilik alamat tempat tinggal);</li>
                                            <li>Foto asli buku nikah yang ada data pengantin suami istri;</li>
                                            <li>Foto asli form F1.06 perubahan elemen data dan dokumen pendukung asli perubahan data jika ada perubahan data, misal: perubahan pendidikan, pekerjaan, agama, status pernikahan (dari belum kawin/cerai menjadi kawin tercatat) dll contoh: pendidikan terakhir semua SLTP/Sederajat menjadi S1, maka melampirkan foto asli IJAZAH S1.</li>
                                        </ul>
                                        <ul class='font-bold pl-4 space-y-0 mt-1'>2. PASANGAN DENGAN ALAMAT PROVINSI/KAB BERBEDA</ul>
                                        <ul class='list-disc pl-12 space-y-0 mt-1'>
                                            <li>Foto asli surat pindah/SKPWNI dari Dukcapil asal;</li>
                                            <li>Foto KTP lama asli yang pindah;</li>
                                            <li>Foto asli buku nikah yang ada data pengantin suami istri;</li>
                                            <li>Foto KK asli Tapin yang sudah ditandatangani Kepala Keluarga (jika alamat tujuan di surat-pindah dan KK Tapin-nya sama);</li>
                                            <li>Foto asli form F1.06 perubahan elemen data dan dokumen pendukung asli perubahan data jika ada perubahan data, misal: perubahan pendidikan, pekerjaan, agama, status pernikahan (dari belum kawin/cerai menjadi kawin tercatat) dll contoh: pendidikan terakhir semua SLTP/Sederajat menjadi S1, maka melampirkan foto asli IJAZAH S1.</li>
                                            <li>Foto asli Surat pernyataan tempat tinggal di Tapin bermaterai terbaru Rp.10,000 dan ditandatangani ybs, ditandatangani RT dan di beri cap RT (jika kost/kontrak/numpang alamat yang bertandatangan pemilik alamat tempat tinggal);</li>
                                            <li>Mendapatkan KK suami istri dan KK orangtua (jika KK lama masih menjadi satu dengan orangtua);</li>
                                        </ul>
                                        <br>
                                        <p>Semua format formulir yang dibutuhkan, dapat diunduh <a href='https://pondok.dukcapil.tapinkab.go.id/formulir' target='_blank' class='text-blue-600 underline'>disini</a>.</p>
                                    </div>
                                    <div class='mt-4 pt-3 border-t border-gray-200'></div>
                                    <div class='bg-gray-100 py-4 px-4 sm:px-4 rounded-md'>
                                        <div class='flex justify-between gap-2 fade-in-card'>
                                            <button type='button' class='btn-masuk flex-1 px-4 py-2 h-10 bg-green-600 text-white font-medium rounded-sm hover:bg-green-700 focus:outline-none'>Ajukan Kedatangan</button>
                                            <button type='button' class='btn-daftar flex-1 px-4 py-2 h-10 bg-blue-600 text-white font-medium rounded-sm hover:bg-blue-700 focus:outline-none'>Status Permohonan</button>
                                        </div>
                                    </div>
                                    `,
                                    '/form_pengajuan?keterangan=DTG&judul=Lapor%20Kedatangan&icon=kedatangan.png',
                                    '/login',
                                    '/register'
                                )"
                                class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 text-xs font-medium rounded-md hover:bg-blue-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Informasi
                            </button>
                            <button type="button"
                                onclick="event.preventDefault(); event.stopPropagation(); cekStatusTransaksi();"
                                class="px-4 py-2 bg-blue-600 text-white text-xs font-medium rounded-md hover:bg-blue-700">
                                Status
                            </button>
                        @else
                            <a href="/form_pengajuan?keterangan=DTG&judul=Lapor%20Kedatangan&icon=kedatangan.png"
                                class="inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white text-xs font-medium rounded-md hover:bg-green-700 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Ajukan Permohonan
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>

        {{-- Pindah Keluar --}}
        <div class="p-2 fade-in-card">
            <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-500 ease-out border-2 border-transparent hover:shadow-xl hover:scale-[1.02] hover:border-blue-500 cursor-pointer h-full">
                <div class="bg-blue-50 p-6 flex justify-center">
                    <img src="{{ asset('icon/pindah.png') }}" alt="Pindah Keluar" class="w-32 h-32 object-contain">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Pindah Keluar</h3>
                    <p class="text-gray-600 text-sm mb-4">Pengajuan pindah menjadi warga kabupaten lain diluar Tapin</p>
                    <div class="flex space-x-2">
                        @guest
                            <button type="button"
                                onclick="event.preventDefault(); event.stopPropagation(); showPanduanRich(
                                    'Layanan Perpindahan Penduduk',
                                    `
                                    <div class='p-0 sm:p-1 text-gray-700 rounded-lg text-xs sm:text-sm leading-relaxed' style='text-align: left !important'>
                                        <div class='flex flex-col items-center mb-4'>
                                            <svg xmlns='http://www.w3.org/2000/svg' width='48' height='48' viewBox='0 0 24 24' fill='none' stroke='#3B82F6' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'>
                                                <rect x='4' y='12' width='16' height='5' rx='1'/>
                                                <path d='M6 12V9h12v3'/>
                                                <circle cx='7' cy='19' r='1.5'/>
                                                <circle cx='17' cy='19' r='1.5'/>
                                                <path d='M6 6h12'/>
                                                <path d='M16 4l2 2-2 2'/>
                                            </svg>
                                            <h3 class='mt-2 text-lg font-bold text-blue-500'>Layanan Pindah Keluar</h3>
                                        </div>
                                        <p>Layanan Pindah Keluar merupakan Layanan pindah keluar dalam konteks administrasi kependudukan adalah proses administratif yang dilakukan oleh penduduk ketika mereka hendak pindah dari satu wilayah ke wilayah lain. Layanan ini dikelola oleh instansi pemerintah, seperti Dinas Kependudukan dan Catatan Sipil (Disdukcapil), dengan tujuan untuk mencatat perpindahan penduduk secara resmi dan memastikan data kependudukan tetap akurat.</p>
                                        <br>
                                        <p>Pastikan Anda telah menyiapkan lampiran foto berkas pendukung asli yang dibutuhkan (bukan fotocopy) dan astikan foto berkas dapat terbaca dengan jelas, diantaranya.</p>
                                        <ul class='list-disc pl-5 space-y-1 mt-2'>
                                            <li>KK dan KTP Tapin, bagi anak di bawah umur wajib melampirkan surat persetujuan dari kepala keluarga dan KK tujuan, serta pernyataan persetujuan dari kepala keluarga KK yang akan ditumpangi.</li>
                                            <li>Alamat lengkap tujuan pindah, termasuk nomor RT dan Kodepos. Data yang tidak lengkap akan mengakibatkan permohonan ditolak.</li>
                                        </ul>
                                        <br>
                                        <p>Selengkapnya mengenai tata cara dan persyaratan pengajuan layanan Pindah Keluar, dapat dilihat <a href='https://dukcapil.tapinkab.go.id/pelayanan/skpwni' target='_blank' class='text-blue-600 underline'>disini</a>.</p>
                                        <br>
                                        <p>Silahkan masuk atau daftar aplikasi untuk melanjutkan proses pengajuan permohonan administrasi kependudukan. Semua formulir kependudukan dapat diunduh <a href='https://pondok.dukcapil.tapinkab.go.id/formulir' target='_blank' class='text-blue-600 underline'>disini</a>.</p>
                                    </div>
                                    <div class='mt-4 pt-3 border-t border-gray-200'></div>
                                    <div class='bg-gray-100 py-4 px-4 sm:px-4 rounded-md'>
                                        <div class='flex justify-between gap-2 fade-in-card'>
                                            <button type='button' class='btn-masuk flex-1 px-4 py-2 h-10 bg-green-600 text-white font-medium rounded-sm hover:bg-green-700 focus:outline-none'>Masuk</button>
                                            <button type='button' class='btn-daftar flex-1 px-4 py-2 h-10 bg-blue-600 text-white font-medium rounded-sm hover:bg-blue-700 focus:outline-none'>Daftar</button>
                                        </div>
                                    </div>
                                    `,
                                    '/form_pengajuan?keterangan=PDH&judul=Lapor%20Perpindahan&icon=pindah.png',
                                    '/login',
                                    '/register'
                                )"
                                class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 text-xs font-medium rounded-md hover:bg-blue-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Informasi
                            </button>
                            <button type="button"
                                onclick="event.preventDefault(); event.stopPropagation(); cekStatusTransaksi();"
                                class="px-4 py-2 bg-blue-600 text-white text-xs font-medium rounded-md hover:bg-blue-700">
                                Status
                            </button>
                        @else
                            <a href="/form_pengajuan?keterangan=PDH&judul=Lapor%20Perpindahan&icon=pindah.png"
                                class="inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white text-xs font-medium rounded-md hover:bg-green-700 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Ajukan Permohonan
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>

        {{-- Akta Perkawinan --}}
        <div class="p-2 fade-in-card">
            <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-500 ease-out border-2 border-transparent hover:shadow-xl hover:scale-[1.02] hover:border-blue-500 cursor-pointer h-full">
                <div class="bg-blue-50 p-6 flex justify-center">
                    <img src="{{ asset('icon/perkawinan.png') }}" alt="Akta Perkawinan" class="w-32 h-32 object-contain">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Akta Perkawinan</h3>
                    <p class="text-gray-600 text-sm mb-4">Pengajuan akta perkawinan bagi pernikahan diluar KUA</p>
                    <div class="flex space-x-2">
                        @guest
                            <button type="button"
                                onclick="event.preventDefault(); event.stopPropagation(); showPanduanRich(
                                    'Layanan Akta Perkawinan',
                                    `
                                    <div class='p-0 sm:p-1 text-gray-700 rounded-lg text-xs sm:text-sm leading-relaxed' style='text-align: left !important'>
                                        <div class='flex flex-col items-center mb-4'>
                                            <svg xmlns='http://www.w3.org/2000/svg' width='48' height='48' viewBox='0 0 24 24' fill='none' stroke='#3B82F6' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'>
                                                <path d='M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z'/>
                                            </svg>
                                            <h3 class='mt-2 text-lg font-bold text-blue-500'>Layanan Akta Perkawinan</h3>
                                        </div>
                                        <p>Layanan Akta Perkawinan merupakan layanan pencatatan secara resmi oleh pemerintah atas suatu pernikahan yang telah berlangsung bagi warga Tapin yang beragama non-muslim, sehingga dapat diakui secara hukum. Akta ini dikeluarkan oleh instansi yang berwenang, seperti Dinas Kependudukan dan Pencatatan Sipil (Disdukcapil), dan berfungsi sebagai bukti legal bahwa pernikahan tersebut telah sah secara administrasi. Bagi warga yang beragama Islam tidak perlu mengajukan akta perkawinan karena pencatatan perkawinan dilakukan di KUA.</p>
                                        <br>
                                        <p>Pastikan Anda telah menyiapkan lampiran foto berkas pendukung asli yang dibutuhkan (bukan fotocopy) dan astikan foto berkas dapat terbaca dengan jelas.</p>
                                        <ul class='list-disc pl-5 space-y-1 mt-2'>
                                            <li><strong>Pengajuan Akta Perkawinan</strong> : Melampirkan foto bukti pendukung asli berwarna.</li>
                                            <li><strong>Hilang</strong> : Melampirkan foto surat kehilangan dari Kepolisian.</li>
                                            <li><strong>Rusak</strong> : Melampirkan foto Akta Perkawinan yang rusak.</li>
                                        </ul>
                                        <br>
                                        <p>Selengkapnya mengenai tata cara dan persyaratan pengajuan layanan Akta Perkawinan, dapat dilihat <a href='https://dukcapil.tapinkab.go.id/pelayanan/akta-perkawinan' target='_blank' class='text-blue-600 underline'>disini</a>.</p>
                                        <br>
                                        <p>Silahkan masuk atau daftar aplikasi untuk melanjutkan proses pengajuan permohonan administrasi kependudukan. Semua formulir kependudukan dapat diunduh <a href='https://pondok.dukcapil.tapinkab.go.id/formulir' target='_blank' class='text-blue-600 underline'>disini</a>.</p>
                                    </div>
                                    <div class='mt-4 pt-3 border-t border-gray-200'></div>
                                    <div class='bg-gray-100 py-4 px-4 sm:px-4 rounded-md'>
                                        <div class='flex justify-between gap-2 fade-in-card'>
                                            <button type='button' class='btn-masuk flex-1 px-4 py-2 h-10 bg-green-600 text-white font-medium rounded-sm hover:bg-green-700 focus:outline-none'>Masuk</button>
                                            <button type='button' class='btn-daftar flex-1 px-4 py-2 h-10 bg-blue-600 text-white font-medium rounded-sm hover:bg-blue-700 focus:outline-none'>Daftar</button>
                                        </div>
                                    </div>
                                    `,
                                    '/form_pengajuan?keterangan=AKW&judul=Akta%20Perkawinan&icon=perkawinan.png',
                                    '/login',
                                    '/register'
                                )"
                                class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 text-xs font-medium rounded-md hover:bg-blue-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Informasi
                            </button>
                            <button type="button"
                                onclick="event.preventDefault(); event.stopPropagation(); cekStatusTransaksi();"
                                class="px-4 py-2 bg-blue-600 text-white text-xs font-medium rounded-md hover:bg-blue-700">
                                Status
                            </button>
                        @else
                            <a href="/form_pengajuan?keterangan=AKW&judul=Akta%20Perkawinan&icon=perkawinan.png"
                                class="inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white text-xs font-medium rounded-md hover:bg-green-700 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Ajukan Permohonan
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>

        {{-- Akta Perceraian --}}
        <div class="p-2 fade-in-card">
            <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-500 ease-out border-2 border-transparent hover:shadow-xl hover:scale-[1.02] hover:border-blue-500 cursor-pointer h-full">
                <div class="bg-blue-50 p-6 flex justify-center">
                    <img src="{{ asset('icon/perceraian.png') }}" alt="Akta Perceraian" class="w-32 h-32 object-contain">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Akta Perceraian</h3>
                    <p class="text-gray-600 text-sm mb-4">Pengajuan akta perceraian dengan melampirkan putusan pengadilan</p>
                    <div class="flex space-x-2">
                        @guest
                            <button type="button"
                                onclick="event.preventDefault(); event.stopPropagation(); showPanduanRich(
                                    'Layanan Akta Perceraian',
                                    `
                                    <div class='p-0 sm:p-1 text-gray-700 rounded-lg text-xs sm:text-sm leading-relaxed' style='text-align: left !important'>
                                        <div class='flex flex-col items-center mb-4'>
                                            <svg xmlns='http://www.w3.org/2000/svg' width='48' height='48' viewBox='0 0 24 24' fill='none' stroke='#3B82F6' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'>
                                                <path d='M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z'/>
                                                <path d='M9 9l6 6'/>
                                                <path d='M15 9l-6 6'/>
                                            </svg>
                                            <h3 class='mt-2 text-lg font-bold text-blue-500'>Layanan Akta Perceraian</h3>
                                        </div>
                                        <p>Layanan Akta Perceraian merupakan layanan proses pencatatan resmi oleh pemerintah atas perceraian yang telah disahkan oleh pengadilan. Akta ini dikeluarkan oleh instansi terkait, seperti Dinas Kependudukan dan Pencatatan Sipil (Disdukcapil), dan berfungsi sebagai bukti hukum yang sah atas perpisahan pasangan suami istri.</p>
                                        <br>
                                        <p>Pastikan Anda telah menyiapkan lampiran foto berkas pendukung asli yang dibutuhkan (bukan fotocopy) dan astikan foto berkas dapat terbaca dengan jelas.</p>
                                        <ul class='list-disc pl-5 space-y-1 mt-2'>
                                            <li><strong>Pengajuan Akta Perceraian</strong> : Melampirkan foto bukti pendukung asli berwarna.</li>
                                            <li><strong>Hilang</strong> : Melampirkan foto surat kehilangan dari Kepolisian.</li>
                                            <li><strong>Rusak</strong> : Melampirkan foto Akta Perceraian yang rusak.</li>
                                        </ul>
                                        <br>
                                        <p>Selengkapnya mengenai tata cara dan persyaratan pengajuan layanan Akta Perceraian, dapat dilihat <a href='http://pondok.dukcapil.tapinkab.go.id/persyaratan' target='_blank' class='text-blue-600 underline'>disini</a>.</p>
                                        <br>
                                        <p>Silahkan masuk atau daftar aplikasi untuk melanjutkan proses pengajuan permohonan administrasi kependudukan. Semua formulir kependudukan dapat diunduh <a href='https://pondok.dukcapil.tapinkab.go.id/formulir' target='_blank' class='text-blue-600 underline'>disini</a>.</p>
                                    </div>
                                    <div class='mt-4 pt-3 border-t border-gray-200'></div>
                                    <div class='bg-gray-100 py-4 px-4 sm:px-4 rounded-md'>
                                        <div class='flex justify-between gap-2 fade-in-card'>
                                            <button type='button' class='btn-masuk flex-1 px-4 py-2 h-10 bg-green-600 text-white font-medium rounded-sm hover:bg-green-700 focus:outline-none'>Masuk</button>
                                            <button type='button' class='btn-daftar flex-1 px-4 py-2 h-10 bg-blue-600 text-white font-medium rounded-sm hover:bg-blue-700 focus:outline-none'>Daftar</button>
                                        </div>
                                    </div>
                                    `,
                                    '/form_pengajuan?keterangan=ACR&judul=Akta%20Perceraian&icon=perceraian.png',
                                    '/login',
                                    '/register'
                                )"
                                class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 text-xs font-medium rounded-md hover:bg-blue-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Informasi
                            </button>
                            <button type="button"
                                onclick="event.preventDefault(); event.stopPropagation(); cekStatusTransaksi();"
                                class="px-4 py-2 bg-blue-600 text-white text-xs font-medium rounded-md hover:bg-blue-700">
                                Status
                            </button>
                        @else
                            <a href="/form_pengajuan?keterangan=ACR&judul=Akta%20Perceraian&icon=perceraian.png"
                                class="inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white text-xs font-medium rounded-md hover:bg-green-700 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Ajukan Permohonan
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showPanduanRich(judul, htmlIsi, urlLanjutkan, urlLogin = '/login', urlDaftar = '/register') {
    Swal.fire({
        html: htmlIsi,
        showCloseButton: true,
        showConfirmButton: false,
        showCancelButton: false,
        width: '550px',
        customClass: {
            popup: 'rounded-sm max-w-xl',
            content: 'text-xs sm:text-sm leading-relaxed text-left'
        },
        didOpen: () => {
            const btnMasuk = document.querySelector('.btn-masuk');
            const btnDaftar = document.querySelector('.btn-daftar');
            if (btnMasuk) btnMasuk.addEventListener('click', () => window.location.href = urlLogin);
            if (btnDaftar) btnDaftar.addEventListener('click', () => window.location.href = urlDaftar);
        }
    });
}

// === FUNGSI BARU: CEK STATUS TRANSAKSI ===
function maskNik(nik) {
    if (!nik || nik.length < 6) return 'xxxxxx';
    return nik.substring(0, 6) + 'xxxxxxxxxx';
}

function cekStatusTransaksi() {
    Swal.fire({
        title: 'Cek Status Permohonan',
        html: `
            <div class="text-left mb-4">
                <label for="swal-nik" class="block text-sm font-medium text-gray-700 mb-1">NIK</label>
                <input id="swal-nik" type="text" maxlength="16" placeholder="Masukkan NIK 16 digit" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="text-left mb-4">
                <label for="swal-id-trx" class="block text-sm font-medium text-gray-700 mb-1">Nomor Transaksi (ID Trx)</label>
                <input id="swal-id-trx" type="text" placeholder="Contoh: TRX20260112001" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Cek Status',
        cancelButtonText: 'Batal',
        customClass: {
            popup: 'rounded-sm max-w-xl',
            content: 'text-xs sm:text-sm leading-relaxed'
        },
        preConfirm: () => {
            const nik = document.getElementById('swal-nik').value.trim();
            const id_trx = document.getElementById('swal-id-trx').value.trim();

            if (!nik || !id_trx) {
                Swal.showValidationMessage('NIK dan Nomor Transaksi wajib diisi!');
                return false;
            }

            if (!/^\d{16}$/.test(nik)) {
                Swal.showValidationMessage('NIK harus terdiri dari 16 digit angka!');
                return false;
            }

            return fetch(`/cek-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ nik, id_trx })
            })
            .then(response => response.json())
            .catch(error => {
                throw new Error('Gagal menghubungi server.');
            });
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const data = result.value;

            if (data.success && data.transaksi) {
                const fmtDate = (dateStr) => {
                    if (!dateStr) return '-';
                    const d = new Date(dateStr);
                    return d.toLocaleDateString('id-ID', {
                        day: '2-digit',
                        month: 'long',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                };

                let statusText = '';
                switch(data.transaksi.status) {
                    case 1: statusText = 'Baru, Menunggu Verifikasi'; break;
                    case 2: statusText = 'Diverifikasi'; break;
                    case 3: statusText = 'Dalam Proses'; break;
                    case 4: statusText = 'Selesai'; break;
                    case 5: statusText = 'Ditolak'; break;
                    case 6: statusText = 'Diajukan Ulang'; break;
                    default: statusText = 'Tidak Diketahui';
                }

                Swal.fire({
                    title: 'Riwayat Permohonan',
                    html: `
                        <div class="text-left space-y-3 text-sm">
                            <div><strong>NIK :</strong> ${maskNik(data.transaksi.nik)}</div>
                            <div><strong>ID Transaksi :</strong> ${data.transaksi.id_trx}</div>
                            <div><strong>Layanan :</strong> ${data.transaksi.nama_layanan}</div>
                            <div><strong>Status :</strong> <span class="font-semibold ${data.transaksi.status == 4 ? 'text-green-600' : data.transaksi.status == 5 ? 'text-red-600' : ''}">${statusText}</span></div>
                            <div><strong>Tgl. Pengajuan :</strong> ${fmtDate(data.transaksi.created_at)}</div>
                            ${data.transaksi.tgl_proses ? `<div><strong>Tgl. Selesai:</strong> ${fmtDate(data.transaksi.tgl_proses)}</div>` : ''}
                            ${data.transaksi.tgl_selesai ? `<div><strong>Tgl. Selesai:</strong> ${fmtDate(data.transaksi.tgl_selesai)}</div>` : ''}
                            ${data.transaksi.pesan ? `<div><strong>Catatan:</strong> <em>${data.transaksi.pesan}</em></div>` : ''}
                        </div>
                    `,
                    icon: 'info',
                    confirmButtonText: 'Tutup',
                    customClass: {
                        popup: 'rounded-sm max-w-lg',
                        content: 'text-xs sm:text-sm'
                    }
                });
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Data Tidak Valid',
                    text: data.message || 'NIK dan Nomor Transaksi tidak ditemukan atau tidak sesuai.',
                    confirmButtonText: 'OK'
                });
            }
        }
    }).catch(err => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: err.message || 'Terjadi kesalahan tak terduga.',
            confirmButtonText: 'OK'
        });
    });
}
</script>

<style>
/* Fade-in animation */
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px) scale(0.98); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}
.fade-in-card { opacity: 0; animation: fadeInUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
.fade-in-card:nth-child(1) { animation-delay: 0.1s; }
.fade-in-card:nth-child(2) { animation-delay: 0.15s; }
.fade-in-card:nth-child(3) { animation-delay: 0.2s; }
.fade-in-card:nth-child(4) { animation-delay: 0.25s; }
.fade-in-card:nth-child(5) { animation-delay: 0.3s; }
.fade-in-card:nth-child(6) { animation-delay: 0.35s; }
.fade-in-card:nth-child(7) { animation-delay: 0.4s; }
.fade-in-card:nth-child(8) { animation-delay: 0.45s; }
.fade-in-card:nth-child(9) { animation-delay: 0.5s; }

/* SweetAlert Backdrop Blur */
.swal2-container {
    background: rgba(255, 255, 255, 0.05) !important;
    backdrop-filter: blur(5px);
    -webkit-backdrop-filter: blur(5px);
    will-change: backdrop-filter;
}
.swal2-popup {
    border-top: 2px solid #3B82F6 !important;
    border-bottom: 2px solid #3B82F6 !important;
}
.swal-title-small { font-size: 1rem !important; font-weight: 600; }
.swal2-icon { width: 2.5rem !important; height: 2.5rem !important; font-size: 2rem !important; margin: 0.5rem auto 1rem !important; }
@media (max-width: 640px) {
    .swal-title-small { font-size: 1.1rem !important; }
    .swal2-popup { width: 95% !important; padding: 1rem !important; }
    .swal2-html-container { padding: 0.75rem 1rem !important; font-size: 0.875rem !important; }
    .swal2-title { font-size: 1.1rem !important; padding: 0.5rem 1rem !important; }
    .swal2-icon { width: 2rem !important; height: 2rem !important; font-size: 1.5rem !important; margin: 0.25rem auto 0.75rem !important; }
    .btn-masuk, .btn-daftar { font-size: 0.8125rem !important; padding: 0.65rem 0.75rem !important; min-height: 2.5rem !important; }
}
</style>
@endsection