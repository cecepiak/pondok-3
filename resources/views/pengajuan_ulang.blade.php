@extends('layouts.app')
@section('content')
<div x-data="formPengajuan" x-init="$nextTick(() => { initData(); })">
    <div class="max-w-4xl mx-auto min-h-screen flex-col justify-center items-center py-12 px-4">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-white border-b border-gray-100 p-6 sm:p-5">
                <h2 class="text-2xl font-bold text-gray-800 mb-5 text-center sm:text-left">
                    Pengajuan Ulang : {{ $transaksi->id_trx }}
                </h2>

                <!-- Stepper -->
                <div class="flex flex-col sm:flex-row items-stretch w-full overflow-hidden border rounded-xl bg-gray-50">
                    <!-- Step 1 -->
                    <div class="relative flex-1 flex items-center py-3 pl-6 pr-4 transition-all sm:[clip-path:polygon(0%_0%,_95%_0%,_100%_50%,_95%_100%,_0%_100%)]"
                        :class="currentStep === 1 ? 'bg-red-600 text-white' : (currentStep > 1 ? 'bg-white text-red-600' : 'bg-white text-gray-400')">
                        <div class="flex items-center space-x-3">
                            <div :class="currentStep > 1 ? 'bg-red-600 text-white border-red-600' : (currentStep === 1 ? 'bg-white text-red-600 border-white' : 'border-gray-300')"
                                class="w-7 h-7 border-2 rounded-full flex items-center justify-center font-bold text-xs flex-shrink-0 transition-colors">
                                <template x-if="currentStep > 1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                                </template>
                                <template x-if="currentStep <= 1"><span>01</span></template>
                            </div>
                            <span class="text-sm font-bold">Perhatian</span>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="relative flex-1 flex items-center py-3 pl-6 pr-4 transition-all sm:[clip-path:polygon(95%_0%,_100%_50%,_95%_100%,_0%_100%,_5%_50%,_0%_0%)]"
                        :class="currentStep === 2 ? 'bg-yellow-400 text-black' : (currentStep > 2 ? 'bg-white text-black-400' : 'bg-white text-gray-400')">
                        <div class="flex items-center space-x-3">
                            <div :class="currentStep > 2 ? 'bg-yellow-400 text-white border-yellow-400' : (currentStep === 2 ? 'bg-white text-black-400 border-yellow-400' : 'border-gray-300')"
                                class="w-7 h-7 border-2 rounded-full flex items-center justify-center font-bold text-xs flex-shrink-0 transition-colors">
                                <template x-if="currentStep > 2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                                </template>
                                <template x-if="currentStep <= 2"><span>02</span></template>
                            </div>
                            <span class="text-sm font-bold">Data Permohonan</span>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="relative flex-1 flex items-center py-3 pl-6 pr-4 transition-all sm:[clip-path:polygon(95%_0%,_100%_50%,_95%_100%,_0%_100%,_5%_50%,_0%_0%)]"
                        :class="currentStep === 3 ? 'bg-green-600 text-white' : (currentStep > 3 ? 'bg-white text-green-600' : 'bg-white text-gray-400')">
                        <div class="flex items-center space-x-3">
                            <div :class="currentStep > 3 ? 'bg-green-600 text-white border-green-600' : (currentStep === 3 ? 'bg-white text-green-600 border-white' : 'border-gray-300')"
                                class="w-7 h-7 border-2 rounded-full flex items-center justify-center font-bold text-xs flex-shrink-0 transition-colors">
                                <template x-if="currentStep > 3">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                                </template>
                                <template x-if="currentStep <= 3"><span>03</span></template>
                            </div>
                            <span class="text-sm font-bold">Lampiran</span>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="relative flex-1 flex items-center py-3 pl-6 pr-4 transition-all sm:[clip-path:polygon(100%_0%,_100%_100%,_0%_100%,_5%_50%,_0%_0%)]"
                        :class="currentStep === 4 ? 'bg-blue-600 text-white' : 'bg-white text-gray-400'">
                        <div class="flex items-center space-x-3">
                            <div :class="currentStep === 4 ? 'bg-white text-blue-600 border-white' : 'border-gray-300'"
                                class="w-7 h-7 border-2 rounded-full flex items-center justify-center font-bold text-xs flex-shrink-0 transition-colors">
                                <span>04</span>
                            </div>
                            <span class="text-sm font-bold">Pratinjau</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="p-6 sm:p-5">
                <!-- Step 1: Perhatian -->
                <div x-show="currentStep === 1" x-transition.opacity>
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                        <h3 class="text-red-800 font-bold mb-1">Peringatan Penting!</h3>
                        <p class="text-red-700 text-sm italic">"Barang siapa dengan sengaja melakukan pemalsuan identitas diri atau dokumen terhadap instansi pelaksana, maka dapat terancam hukuman pidana 6 tahun atau denda sebesar lima puluh juta rupiah"</p>
                        <p class="text-[10px] text-red-600 mt-2 uppercase font-semibold">Undang-Undang No.23 Tahun 2006 Bab 12</p>
                    </div>

                    <div class="space-y-3 text-sm text-gray-600 mb-8">
                        <template x-for="info in ['Pastikan, dalam Pengajuan Ulang Anda sudah mempersiapkan Persyaratan yang harus dilengkapi sesuai informasi dari Petugas.', 'Lampiran berkas wajib berupa foto dokumen asli, bukan hasil fotokopi. Lampiran dengan berkas fotokopi otomatis akan tertolak.', 'Petugas berhak menolak pengajuan dengan data atau lampiran persyaratan yang tidak sesuai prosedur.', 'Informasi status permohonan akan ditampilkan pada Menu Lacak, Lihat Bukti, atau Tombol Status.', 'Jika status pengajuan Ditolak, maka pemohon dapat Mengajukan Ulang status Ditolak pada Menu Lacak, tidak disarankan membuat pengajuan Baru yang sama.']">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span x-text="info"></span>
                            </div>
                        </template>
                    </div>

                    <div class="bg-gray-50 rounded-2xl p-5 border transition-all" :class="isAgreed ? 'border-green-200 bg-green-50/30' : 'border-gray-200'">
                        <label class="flex items-start cursor-pointer group">
                            <div class="relative inline-flex items-center cursor-pointer flex-shrink-0 mt-0.5">
                                <input type="checkbox" x-model="isAgreed" class="sr-only peer">
                                <div class="w-12 h-6 bg-gray-300 rounded-full peer peer-checked:bg-green-500 after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-6"></div>
                            </div>
                            <span class="ml-4 text-[12px] text-gray-700 leading-relaxed">
                                <span class="font-semibold" :class="isAgreed ? 'text-green-700' : 'text-gray-900'">Konfirmasi Persetujuan:</span><br>
                                Saya memahami, menyetujui, dan akan mengikuti aturan yang berlaku. Saya bersedia menerima konsekuensi hukum apabila melakukan pelanggaran.
                            </span>
                        </label>
                    </div>

                    <div x-show="errors.agreement && !isAgreed" class="mt-3 flex items-center p-3 text-sm text-red-800 border border-red-200 rounded-xl bg-red-50">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" /></svg>
                        <span class="font-bold text-xs" x-text="errors.agreement"></span>
                    </div>
                </div>

                <!-- Step 2: Formulir -->
                <div x-show="currentStep === 2" x-transition class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-sm font-bold text-gray-700">NIK Pemohon <span class="text-red-500">*</span></label>
                            <input type="text" x-model="formData.nik" @input="formData.nik = $event.target.value.replace(/[^0-9]/g, '')" maxlength="16" class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none transition shadow-sm bg-gray-50" placeholder="16 digit NIK" readonly>
                            <p x-show="errors.nik" x-text="errors.nik" class="text-[11px] text-red-500 italic font-bold"></p>
                        </div>
                        <div class="space-y-1">
                            <label class="text-sm font-bold text-gray-700">Nomor Kartu Keluarga <span class="text-red-500">*</span></label>
                            <input type="text" x-model="formData.kk" @input="formData.kk = $event.target.value.replace(/[^0-9]/g, '')" maxlength="16" class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none transition shadow-sm bg-gray-50" placeholder="16 digit KK" readonly>
                            <p x-show="errors.kk" x-text="errors.kk" class="text-[11px] text-red-500 italic font-bold"></p>
                        </div>

                        <div class="space-y-1">
                            <label class="text-sm font-bold text-gray-700">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" x-model="formData.nama" @input="formData.nama = $event.target.value.toUpperCase()" class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none transition shadow-sm bg-gray-50" placeholder="Nama Lengkap" readonly>
                            <p x-show="errors.nama" x-text="errors.nama" class="text-[11px] text-red-500 italic font-bold"></p>
                            <p class="text-[11px] text-gray-500 italic text-left" style="text-transform: none;">* Data NIK, KK, dan Nama otomatis dari data transaksi sebelumnya.</p>
                        </div>

                        <div class="space-y-1">
                            <label class="text-sm font-bold text-gray-700">Pengambilan Dokumen <span class="text-red-500">*</span></label>
                            <select
                                x-on:change="
                                    formData.pengambilan_id = $event.target.value;
                                    const selected = listPengambilan.find(p => p.id == formData.pengambilan_id);
                                    formData.nama_pengambilan = selected ? selected.nama : '';
                                "
                                class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none transition"
                            >
                                <option value="">Pilih Tempat Pengambilan</option>
                                <template x-for="item in listPengambilan" :key="item.id">
                                    <option :value="item.id" x-text="item.nama" :selected="String(item.id) === String(formData.pengambilan_id)"></option>
                                </template>
                            </select>
                            <p x-show="errors.pengambilan_id" x-text="errors.pengambilan_id" class="text-[11px] text-red-400 italic font-bold"></p>
                            <p class="text-[11px] text-gray-500 italic text-left" style="text-transform: none;">* Pilih tempat penyerahan dan pengambilan Dokumen.</p>
                        </div>

                        <!-- JENIS LAYANAN (DIPERBAIKI) -->
                        <div class="md:col-span-2 space-y-1">
                            <label class="text-sm font-bold text-gray-700">Jenis Layanan <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                <template x-for="item in listLayanan" :key="item.id">
                                    <label 
                                        class="flex items-center p-2 border-2 rounded-lg cursor-pointer transition-all duration-200"
                                        :class="formData.selectedLayanan.includes(String(item.id)) ? 'border-green-500 bg-green-50 ring-2 ring-green-100' : 'border-gray-100 bg-white hover:border-green-200'"
                                    >
                                        <input type="checkbox" :value="String(item.id)" x-model="formData.selectedLayanan" class="w-5 h-5 accent-green-600">
                                        <span class="ml-4 text-sm font-bold text-gray-800" x-text="item.nama"></span>
                                    </label>
                                </template>
                            </div>
                            <p x-show="errors.id_dokumen" x-text="errors.id_dokumen" class="text-[11px] text-red-500 italic font-bold"></p>
                        </div>

                        <div class="md:col-span-2 space-y-1">
                            <label class="text-sm font-bold text-gray-700">Keterangan Permohonan <span class="text-red-500">*</span></label>
                            <textarea x-model="formData.keterangan_user" @input="formData.keterangan_user = $event.target.value.toUpperCase()" rows="2" class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 outline-none transition resize-none" placeholder="Ceritakan lebih lanjut tentang permohonan Anda..."></textarea>
                            <p x-show="errors.keterangan_user" x-text="errors.keterangan_user" class="text-[11px] text-red-500 italic font-bold"></p>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Lampiran -->
                <div x-show="currentStep === 3" class="space-y-4" x-init="$watch('currentStep', value => { if(value === 3) setTimeout(resizeCanvas, 200) })">
                    <!-- Catatan Petugas / Alasan Penolakan (Merah Warning) -->
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl shadow-sm">
                        <div class="flex items-center text-red-800 mb-3">
                            <svg class="w-6 h-6 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <h4 class="font-bold text-sm">Pesan Petugas (Alasan Penolakan):</h4>
                        </div>
                        <div class="text-[12px] text-red-700 ml-8 font-semibold whitespace-pre-line bg-red-100/50 p-3 rounded-lg border border-red-200/50">
                            {{ $transaksi->pesan ?? 'Tidak ada pesan khusus dari petugas.' }}
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-bold text-gray-700">Lampiran Persyaratan <span class="text-red-500">*</span></label>
                        <div class="border border-gray-200 rounded-2xl p-4 bg-white shadow-sm min-h-[150px]">
                            <div class="relative border-2 border-dashed border-gray-200 rounded-xl p-6 hover:bg-gray-50 transition mb-4 flex flex-col items-center justify-center group">
                                <input type="file" accept="image/*" @change="handleFile($event, 'file')" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-30">
                                <div class="flex flex-col items-center pointer-events-none">
                                    <div class="bg-blue-50 w-10 h-10 rounded-full flex items-center justify-center mb-2 text-blue-600">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-width="2" stroke-linecap="round" /></svg>
                                    </div>
                                    <p class="text-xs text-gray-500">Seret & Jatuhkan berkas atau <span class="text-blue-600 font-bold">Jelajahi</span></p>
                                </div>
                            </div>
                            <div class="flex flex-wrap gap-3">
                                <template x-for="(src, index) in previews.file" :key="index">
                                    <div class="relative w-28 h-28 rounded-lg overflow-hidden border shadow-sm">
                                        <img :src="src" class="w-full h-full object-cover">
                                        <button type="button" @click="removeFile('file', index)" class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="2" /></svg>
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-gray-700">Foto Selfie <span class="text-red-500">*</span></label>
                            <div class="border border-gray-200 rounded-2xl p-4 bg-white shadow-sm">
                                <div class="flex flex-col items-center justify-center p-6 border-2 border-dashed border-gray-200 rounded-xl">
                                    <button type="button" onclick="openCameraModal()" class="flex flex-col items-center group">
                                        <div class="bg-gray-100 w-16 h-16 rounded-2xl flex items-center justify-center mb-3 group-hover:bg-blue-50 transition">
                                            <svg class="w-8 h-8 text-gray-500 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                        </div>
                                        <span class="text-sm font-bold text-blue-600">Ambil Photo</span>
                                    </button>

                                    <div id="selfie-preview-container" class="mt-4 hidden">
                                        <div class="relative w-40 h-40 rounded-2xl overflow-hidden border-2 border-gray-200 shadow-lg group">
                                            <img id="selfie-result" class="w-full h-full object-cover">
                                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center gap-4 opacity-0 group-hover:opacity-100 transition-opacity">
                                                <button type="button" onclick="reviewFoto()" class="bg-white/20 p-2 rounded-full hover:bg-white/40 transition" title="Lihat Foto"><svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg></button>
                                                <button type="button" onclick="openCameraModal()" class="bg-white/20 p-2 rounded-full hover:bg-white/40 transition" title="Foto Ulang"><svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg></button>
                                            </div>
                                            <button type="button" onclick="removeSelfie()" class="absolute top-1 left-1 bg-red-600 text-white rounded-full p-1 shadow-md"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="2" /></svg></button>
                                        </div>
                                    </div>

                                    <div id="modal-review" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/90 p-4" onclick="closeReview()">
                                        <div class="relative max-w-2xl w-full">
                                            <img id="img-full-preview" class="w-full rounded-xl shadow-2xl border-4 border-white">
                                            <p class="text-white text-center mt-4 font-bold">Klik di mana saja untuk menutup</p>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="selfie-data" />
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-bold text-gray-700">Tanda Tangan Digital <span class="text-red-500">*</span></label>
                            <div class="border border-gray-200 rounded-2xl p-4 bg-white shadow-sm flex flex-col items-center">
                                <div class="relative w-full h-[220px] border-2 border-dashed border-gray-200 rounded-xl bg-gray-50 overflow-hidden">
                                    <canvas id="signature-pad" class="absolute inset-0 w-full h-full touch-none cursor-crosshair"></canvas>
                                </div>
                                <button type="button" onclick="clearSignature()" class="mt-3 text-[10px] font-bold text-red-500 uppercase hover:underline">Hapus Tanda Tangan</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 4: Pratinjau -->
                <div x-show="currentStep === 4" x-transition.opacity>
                    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 space-y-4">
                        <div class="flex justify-between border-b pb-2 text-sm"><span class="text-gray-500">NIK:</span><span class="font-bold" x-text="formData.nik"></span></div>
                        <div class="flex justify-between border-b pb-2 text-sm"><span class="text-gray-500">KK:</span><span class="font-bold" x-text="formData.kk"></span></div>
                        <div class="flex justify-between border-b pb-2 text-sm"><span class="text-gray-500">Nama:</span><span class="font-bold" x-text="formData.nama"></span></div>
                        <div class="flex justify-between border-b pb-2 text-sm"><span class="text-gray-500">Jenis Pelayanan:</span><span class="font-bold" x-text="getSelectedLayananNames()"></span></div>
                        <div class="flex justify-between border-b pb-2 text-sm"><span class="text-gray-500">Pengambilan:</span><span class="font-bold" x-text="formData.nama_pengambilan || 'Belum dipilih'"></span></div>
                        <div class="flex justify-between border-b pb-2 text-sm"><span class="text-gray-500">Catatan:</span><span class="font-bold" x-text="formData.keterangan_user"></span></div>
                        <div class="flex justify-between border-b pb-2 text-sm"><span class="text-gray-500">Lampiran Berkas:</span><span class="text-green-600 font-bold" x-text="previews.file.length + ' File diunggah'"></span></div>
                        <div class="flex justify-between border-b pb-2 text-sm"><span class="text-gray-500">Lampiran Selfie:</span><span class="text-green-600 font-bold" x-text="formData.file_selfie ? '1 Foto diunggah' : 'Belum ada foto selfie'"></span></div>
                        <div class="flex justify-between border-b pb-2 text-sm"><span class="text-gray-500">Lampiran TTD:</span><span class="text-green-600 font-bold" x-text="formData.signature ? '1 TTE diunggah' : 'Belum ada tanda tangan'"></span></div>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="mt-6 pt-4 border-t border-gray-200 flex flex-col-reverse sm:flex-row justify-between items-center gap-3">
                    <button type="button" x-show="currentStep > 1" @click="prevStep" class="w-full sm:w-auto px-5 py-2 text-sm bg-gray-100 text-gray-600 font-semibold rounded-lg hover:bg-gray-200 transition">Sebelumnya</button>
                    <button type="button" x-show="currentStep < 4" @click="nextStep" class="w-full sm:w-auto ml-auto px-6 py-2 text-sm bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition active:scale-95">Selanjutnya</button>
                    <button id="submit-btn" type="button" x-show="currentStep === 4" @click="submitForm()" class="w-full sm:w-auto ml-auto px-6 py-2 text-sm bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition active:scale-95">Ajukan Ulang</button>
                </div>
            </div>
        </div>
        <p class="text-center text-gray-500 text-xs mt-6">© 2025 Pondok Dukcapil - Layanan Online</p>
    </div>

    <span x-effect="
        if (currentStep === 3) {
            setTimeout(() => {
                loadSignature();
                resizeCanvas && resizeCanvas();
            }, 300);
        }
    " class="hidden"></span>
</div>

<!-- Camera Modal -->
<div id="camera-modal" class="fixed inset-0 z-[99] hidden items-center justify-center bg-black/80 p-4">
    <div class="bg-white rounded-2xl overflow-hidden w-full max-w-md shadow-2xl">
        <div class="p-4 border-b flex justify-between items-center">
            <h3 class="font-bold text-gray-800">Ambil Foto Selfie</h3>
            <button onclick="closeCameraModal()" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
        </div>
        <div class="relative bg-black aspect-square overflow-hidden">
            <video id="webcam" class="w-full h-full object-cover" autoplay playsinline></video>
            <canvas id="canvas" class="hidden"></canvas>
        </div>
        <div class="p-4 flex justify-center gap-4 bg-gray-50">
            <button onclick="closeCameraModal()" class="px-6 py-2 border border-gray-300 rounded-xl text-sm font-bold text-gray-600 bg-white hover:bg-gray-100 transition">Batal</button>
            <button onclick="capturePhoto()" class="px-6 py-2 bg-blue-600 text-white rounded-xl text-sm font-bold hover:bg-blue-700 shadow-lg transition">Ambil Photo</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<style>
    input::placeholder, textarea::placeholder { text-transform: none; }
    .transition-all { transition: all 0.3s ease; }
    input[type="file"] { min-height: 100px; }
    .spinner { display: inline-block; width: 16px; height: 16px; border: 2px solid rgba(255, 255, 255, 0.3); border-radius: 50%; border-top: 2px solid #fff; animation: spin 1s linear infinite; margin-left: 8px; }
    @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
</style>

<script>
// ============ Kamera / Selfie ============
let videoStream = null;
const modal = document.getElementById('camera-modal');
const video = document.getElementById('webcam');
const canvas = document.getElementById('canvas');
const selfieResult = document.getElementById('selfie-result');
const previewContainer = document.getElementById('selfie-preview-container');
const modalReview = document.getElementById('modal-review');
const imgFullPreview = document.getElementById('img-full-preview');
const btnTrigger = document.querySelector('[onclick="openCameraModal()"]')?.closest('button');

async function openCameraModal() {
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    try {
        videoStream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: "user" }, audio: false });
        video.srcObject = videoStream;
    } catch (err) {
        console.error("Error akses kamera:", err);
        alert("Tidak dapat mengakses kamera. Pastikan Anda memberikan izin.");
        closeCameraModal();
    }
}

function closeCameraModal() {
    if (videoStream) { videoStream.getTracks().forEach(track => track.stop()); videoStream = null; }
    modal.classList.replace('flex', 'hidden');
}

function capturePhoto() {
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    const context = canvas.getContext('2d');
    context.drawImage(video, 0, 0, canvas.width, canvas.height);
    const imageData = canvas.toDataURL('image/jpeg');

    const hiddenInput = document.getElementById('selfie-data');
    if (hiddenInput) { hiddenInput.value = imageData; hiddenInput.dispatchEvent(new Event('input')); }

    selfieResult.src = imageData;
    previewContainer.classList.remove('hidden');
    if (btnTrigger) btnTrigger.classList.add('hidden');
    closeCameraModal();
}

function removeSelfie() {
    selfieResult.src = "";
    previewContainer.classList.add('hidden');
    if (btnTrigger) btnTrigger.classList.remove('hidden');
}

function reviewFoto() {
    if (selfieResult.src) { imgFullPreview.src = selfieResult.src; modalReview.classList.replace('hidden', 'flex'); }
}
function closeReview() { modalReview.classList.replace('flex', 'hidden'); }

// ============ Signature Pad ============
const canvasSignature = document.getElementById('signature-pad');
const ctx = canvasSignature.getContext('2d');
let drawing = false;
let signaturePad = null;

function resizeCanvas() {
    const rect = canvasSignature.getBoundingClientRect();
    canvasSignature.width = rect.width;
    canvasSignature.height = rect.height;
    ctx.strokeStyle = "#000000";
    ctx.lineWidth = 3;
    ctx.lineCap = "round";
    ctx.lineJoin = "round";
}

window.addEventListener('load', resizeCanvas);
window.addEventListener('resize', resizeCanvas);

function getPos(e) {
    const rect = canvasSignature.getBoundingClientRect();
    const clientX = e.touches ? e.touches[0].clientX : e.clientX;
    const clientY = e.touches ? e.touches[0].clientY : e.clientY;
    return { x: clientX - rect.left, y: clientY - rect.top };
}

function startDrawing(e) {
    drawing = true;
    const pos = getPos(e);
    ctx.beginPath();
    ctx.moveTo(pos.x, pos.y);
    ctx.lineTo(pos.x, pos.y);
    ctx.stroke();
}

function draw(e) {
    if (!drawing) return;
    if (e.cancelable) e.preventDefault();
    const pos = getPos(e);
    ctx.lineTo(pos.x, pos.y);
    ctx.stroke();
}

function stopDrawing() { drawing = false; ctx.closePath(); }

function initSignaturePad() {
    const canvas = document.getElementById('signature-pad');
    if (!canvas) return;
    canvas.width = canvas.offsetWidth;
    canvas.height = canvas.offsetHeight;

    if (typeof SignaturePad !== 'undefined') {
        signaturePad = new SignaturePad(canvas, { minWidth: 1, maxWidth: 2.5, penColor: 'black' });
        signaturePad.onEnd = function () {
            const alpineEl = document.querySelector('[x-data]');
            if (alpineEl && alpineEl.__x) {
                const comp = alpineEl.__x.$data || alpineEl.__x;
                comp.formData.signature = canvas.toDataURL('image/png');
            }
        };
    }
}

canvasSignature.addEventListener('mousedown', startDrawing);
canvasSignature.addEventListener('mousemove', draw);
window.addEventListener('mouseup', stopDrawing);
canvasSignature.addEventListener('touchstart', startDrawing, { passive: false });
canvasSignature.addEventListener('touchmove', draw, { passive: false });
canvasSignature.addEventListener('touchend', stopDrawing);

function clearSignature() {
    ctx.clearRect(0, 0, canvasSignature.width, canvasSignature.height);
    resizeCanvas();
    if (signaturePad) signaturePad.clear();
}
</script>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('formPengajuan', () => ({
        currentStep: 1,
        isAgreed: false,
        
        // ✅ FALLBACK: Data default agar checkbox tetap muncul jika API gagal/kosong
        listLayanan: [
            { id: 1, nama: 'Kartu Keluarga' }, { id: 2, nama: 'KTP' }, 
            { id: 3, nama: 'KIA' }, { id: 4, nama: 'Pindah' },
            { id: 5, nama: 'Datang' }, { id: 6, nama: 'Akta Kelahiran' },
            { id: 7, nama: 'Akta Kematian' }, { id: 8, nama: 'Surat Pengantar KUA' }, 
            { id: 9, nama: 'Lainnya' }
        ],
        listPengambilan: [],
        
        formData: {
            id_trx: '{{ $transaksi->id_trx ?? "" }}',
            nik: '', kk: '', nama: '',
            pengambilan_id: '', nama_pengambilan: '',
            selectedLayanan: [],
            keterangan: '{{ request("keterangan") ?? ($transaksi->keterangan ?? "") }}',
            keterangan_user: '',
            file: [], existing_files: [],
            file_selfie: '', signature: ''
        },
        previews: { file: [], selfie: null },
        errors: {},

        async initData() {
            try {
                // 1. Muat list layanan (Update fallback jika API berhasil)
                const ket = this.formData.keterangan;
                if (ket) {
                    try {
                        const resLayanan = await fetch(`/api/jenis-layanan/filter/${encodeURIComponent(ket)}`);
                        const dataLayanan = await resLayanan.json();
                        if (dataLayanan && dataLayanan.length > 0) {
                            this.listLayanan = dataLayanan;
                        }
                    } catch(e) { console.warn('API Layanan gagal, pakai default', e); }
                }

                // 2. Muat list tempat pengambilan
                try {
                    const resAmbil = await fetch('/api/pengambilan-dokumen');
                    this.listPengambilan = await resAmbil.json();
                } catch(e) { console.error('API Pengambilan gagal', e); }

                // 3. ✅ LOAD SELECTED LAYANAN DARI TRANSAKSI (JSON ARRAY)
                @if($transaksi->id_dokumen)
                    @php
                        $raw = $transaksi->id_dokumen;
                        $ids = is_array($raw) ? $raw : json_decode($raw, true);
                        // Cast ke string agar konsisten dengan :value="String(item.id)" di checkbox
                        $ids = array_map('strval', $ids);
                    @endphp
                    this.formData.selectedLayanan = @json($ids);
                @endif

                // 4. Isi data otomatis dari transaksi
                this.formData.nik = @json($transaksi->nik ?? "");
                this.formData.kk = @json($transaksi->kk ?? "");
                this.formData.nama = @json($transaksi->nama ?? "");
                this.formData.pengambilan_id = @json($transaksi->pengambilan_id ?? "");
                this.formData.keterangan_user = @json($transaksi->keterangan_user ?? $transaksi->keterangan ?? '');
                this.isAgreed = true;

                this.syncNames();

                // 5. Muat ulang file lampiran
@if($transaksi->files && $transaksi->files->count() > 0)
    @foreach($transaksi->files as $file)
        @php
            $filePath = $file->file;
            $fileName = basename($filePath);
            // Cek apakah ini file selfie atau signature
            $isSelfie = stripos($fileName, 'selfie') !== false || stripos($fileName, 'foto') !== false;
            $isSignature = stripos($fileName, 'signature') !== false || stripos($fileName, 'ttd') !== false;
        @endphp
        
        @if(!$isSelfie && !$isSignature)
            // Hanya file persyaratan yang masuk ke previews.file
            this.formData.existing_files.push("{{ $file->file }}");
            this.previews.file.push("{{ asset('storage/' . $file->file) }}");
            this.formData.file.push(new File([""], "{{ basename($file->file) }}", { type: "image/jpeg" }));
        @elseif($isSelfie && !isset($selfieLoaded))
            // Load selfie sekali saja
            const selfieUrl = "{{ asset('storage/' . $file->file) }}";
            this.previews.selfie = selfieUrl;
            this.formData.file_selfie = selfieUrl;
            this.$nextTick(() => {
                const selfieImg = document.getElementById('selfie-result');
                if (selfieImg) selfieImg.src = selfieUrl;
                const pc = document.getElementById('selfie-preview-container');
                if (pc) pc.classList.remove('hidden');
            });
            @php $selfieLoaded = true; @endphp
        @elseif($isSignature && !isset($sigLoaded))
            // Load signature sekali saja
            const sigUrl = "{{ asset('storage/' . $file->file) }}";
            this.formData.signature = sigUrl;
            this.$nextTick(() => {
                this.loadSignatureFromUrl(sigUrl);
            });
            @php $sigLoaded = true; @endphp
        @endif
    @endforeach
@endif

                await this.$nextTick();
                this.validate();

            } catch (e) { console.error('Gagal memuat data:', e); }
        },

        syncNames() {
            if (this.formData.pengambilan_id) {
                const selected = this.listPengambilan.find(p => String(p.id) === String(this.formData.pengambilan_id));
                if (selected) this.formData.nama_pengambilan = selected.nama;
            }
        },

        getSelectedLayanan() {
            if (this.formData.selectedLayanan.length === 0) return null;
            const firstId = String(this.formData.selectedLayanan[0]);
            return this.listLayanan.find(item => String(item.id) === firstId) || null;
        },

        getSelectedLayananNames() {
            if (this.formData.selectedLayanan.length === 0) return 'Belum dipilih';
            return this.formData.selectedLayanan.map(id => {
                const item = this.listLayanan.find(l => String(l.id) === String(id));
                return item ? item.nama : 'Layanan #' + id;
            }).join(', ');
        },

        isSignatureEmpty() {
            const canvas = document.getElementById('signature-pad');
            if (!canvas) return true;
            const blank = document.createElement('canvas');
            blank.width = canvas.width;
            blank.height = canvas.height;
            return canvas.toDataURL() === blank.toDataURL();
        },

        loadSignatureFromUrl(url) {
            const canvas = document.getElementById('signature-pad');
            if (!canvas) return;
            const ctxLocal = canvas.getContext('2d');
            const img = new Image();
            img.onload = () => { ctxLocal.clearRect(0, 0, canvas.width, canvas.height); ctxLocal.drawImage(img, 0, 0); };
            img.src = url;
        },

        handleFile(event, field) {
            const files = Array.from(event.target.files);
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            const maxSize = 2 * 1024 * 1024;
            files.forEach(file => {
                if (!allowedTypes.includes(file.type)) { Swal.fire({ icon: 'error', title: 'Format Salah', text: file.name + ' bukan gambar!' }); return; }
                if (file.size > maxSize) { Swal.fire({ icon: 'warning', title: 'Terlalu Besar', text: file.name + ' melebihi 2MB.' }); return; }
                this.formData[field].push(file);
                const url = URL.createObjectURL(file);
                this.previews[field].push(url);
            });
            event.target.value = '';
        },

        removeFile(field, index) {
            URL.revokeObjectURL(this.previews[field][index]);
            
            // Jika yang dihapus adalah file lama (existing), hapus dari existing_files
            if (field === 'file' && this.formData.existing_files && index < this.formData.existing_files.length) {
                this.formData.existing_files.splice(index, 1);
            }
            
            this.formData[field].splice(index, 1);
            this.previews[field].splice(index, 1);
        },

        validate() {
            this.errors = {};
            if (this.currentStep === 1) { if (!this.isAgreed) this.errors.agreement = 'Pernyataan persetujuan wajib disetujui.'; }
            if (this.currentStep === 2) {
                if (!this.formData.nik || this.formData.nik.length < 16) this.errors.nik = 'NIK wajib 16 digit.';
                if (!this.formData.kk || this.formData.kk.length < 16) this.errors.kk = 'Nomor KK wajib 16 digit.';
                if (!this.formData.nama) this.errors.nama = 'Nama lengkap wajib diisi.';
                if (!this.formData.pengambilan_id) this.errors.pengambilan_id = 'Tempat pengambilan wajib dipilih.';
                if (this.formData.selectedLayanan.length === 0) this.errors.id_dokumen = 'Pilih minimal satu jenis layanan.';
                if (!this.formData.keterangan_user || !this.formData.keterangan_user.trim()) this.errors.keterangan_user = 'Keterangan permohonan wajib diisi.';
            }
            if (this.currentStep === 3) {
                if (this.formData.file.length === 0) this.errors.file = 'Lampiran Berkas wajib diunggah.';
                if (!this.previews.selfie) this.errors.file_selfie = 'Foto Selfie wajib diambil.';
                if (this.isSignatureEmpty() && !this.formData.signature) this.errors.signature = 'Tanda tangan digital wajib diisi.';
            }
            if (Object.keys(this.errors).length > 0) {
                const firstError = Object.values(this.errors)[0];
                Swal.fire({ icon: 'error', title: 'Belum Lengkap', text: firstError });
            }
            return Object.keys(this.errors).length === 0;
        },

        nextStep() {
            if (this.validate()) {
                if (this.currentStep === 3) {
                    const canvas = document.getElementById('signature-pad');
                    this.formData.signature = canvas.toDataURL();
                }
                this.currentStep++;
                window.scrollTo({ top: 0, behavior: 'smooth' });
                if (this.currentStep === 3) {
                    setTimeout(() => { this.loadSignature(); resizeCanvas && resizeCanvas(); }, 300);
                }
            }
        },

        prevStep() {
            if (this.currentStep > 1) {
                this.currentStep--;
                this.errors = {};
                window.scrollTo({ top: 0, behavior: 'smooth' });
                if (this.currentStep === 3) {
                    setTimeout(() => { this.loadSignature(); resizeCanvas && resizeCanvas(); }, 300);
                }
            }
        },

        loadSignature() {
            const canvas = document.getElementById('signature-pad');
            if (!canvas || !this.formData.signature) return;
            const ctxLocal = canvas.getContext('2d');
            const img = new Image();
            img.onload = () => { ctxLocal.clearRect(0, 0, canvas.width, canvas.height); ctxLocal.drawImage(img, 0, 0); };
            img.src = this.formData.signature;
        },

        updateSelfie(imageData) { this.previews.selfie = imageData; this.formData.file_selfie = imageData; },

        initSelfieWatcher() {
            const input = document.getElementById('selfie-data');
            if (input) {
                this.formData.file_selfie = input.value;
                this.previews.selfie = input.value;
                input.addEventListener('input', () => { this.formData.file_selfie = input.value; this.previews.selfie = input.value; });
            }
        },

        submitForm() {
            const btn = document.querySelector('#submit-btn');
            btn.disabled = true;
            const originalText = btn.innerHTML;

            btn.innerHTML = `<span class="flex items-center justify-center">Mengirim... <svg class="ml-2 w-4 h-4 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg></span>`;

            const formData = new FormData();
            formData.append('nik', this.formData.nik);
            formData.append('kk', this.formData.kk);
            formData.append('nama', this.formData.nama);
            formData.append('trx_id', this.formData.id_trx);
            formData.append('mode', 'edit');

            // Kirim array layanan yang dipilih
            this.formData.selectedLayanan.forEach(id => { formData.append('jenis_layanan[]', id); });

            formData.append('pengambilan_id', this.formData.pengambilan_id);
            formData.append('isi_informasi', this.formData.keterangan_user);
            formData.append('ikm', 5);
            formData.append('keterangan', this.formData.keterangan);
            formData.append('no_resi', '');

            this.formData.file.forEach(file => { if (file.size > 0) formData.append('file[]', file); });

            if (this.formData.existing_files && this.formData.existing_files.length > 0) {
                this.formData.existing_files.forEach(path => { formData.append('existing_files[]', path); });
            }

            if (this.formData.file_selfie) formData.append('file_selfie', this.formData.file_selfie);
            if (this.formData.signature) formData.append('signature', this.formData.signature);

            fetch('{{ route("pengajuan.submit") }}', {
                method: 'POST',
                body: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
            })
            .then(response => response.json())
            .then(data => {
                btn.disabled = false;
                btn.innerHTML = originalText;

                if (data.success) {
                    Swal.fire({
                        icon: 'success', title: 'Berhasil!',
                        html: `<p>${data.message}</p><p><strong>ID Transaksi:</strong> <code>${data.id_trx}</code></p><p>Silakan simpan ID ini untuk pengecekan status.</p>`,
                        showCancelButton: true, confirmButtonText: 'Cek Status', cancelButtonText: 'Tutup', allowOutsideClick: false, allowEscapeKey: false
                    }).then((result) => {
                        if (result.isConfirmed) window.location.href = `/tracking/${data.id_trx}`;
                        else window.location.href = '/';
                    });
                } else {
                    let errorMsg = data.message;
                    if (data.errors) errorMsg = Object.values(data.errors).flat().join('<br>');
                    Swal.fire({ icon: 'error', title: 'Gagal', html: errorMsg });
                }
            })
            .catch(error => {
                btn.disabled = false;
                btn.innerHTML = originalText;
                Swal.fire({ icon: 'error', title: 'Error', text: 'Gagal mengirim data. Cek koneksi internet.' });
                console.error('Error:', error);
            });
        }
    }));
});
</script>
@endpush