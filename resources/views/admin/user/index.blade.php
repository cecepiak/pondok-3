@extends('adminlte::page')

@section('title', 'Admin - User')

@section('content_header')
@stop

@section('content')
<div class="container-fluid">
    <!-- Filter Form -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Filter Data Pengguna</h5>
        </div>
        <div class="card-body">
            <form method="GET">
                <div class="row">
                    <div class="col-md-3">
                        <input type="text" name="nik" class="form-control" placeholder="Masukan NIK" value="{{ request('nik') }}">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="nama" class="form-control" placeholder="Masukan Nama" value="{{ request('nama') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="kecamatan" class="form-control">
                            <option value="">Pilih Kecamatan</option>
                            @foreach($kecamatans as $kec)
                                <option value="{{ $kec->id }}" {{ request('kecamatan') == $kec->id ? 'selected' : '' }}>
                                    {{ $kec->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="desa_kel" class="form-control">
                            <option value="">Pilih Desa/Kel</option>
                        </select>
                    </div>
                    <div class="col-md-3 mt-3">
                        <select name="level" class="form-control">
                            <option value="">Pilih Level</option>
                            @foreach($levels as $level)
                                <option value="{{ $level->id }}" {{ request('level') == $level->id ? 'selected' : '' }}>
                                    {{ $level->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mt-3">
                        <input type="text" name="no_hp" class="form-control" placeholder="Masukan No Hp" value="{{ request('no_hp') }}">
                    </div>
                    <div class="col-md-6 mt-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary">Cari 🔍</button>
                        <a href="{{ route('admin.user.index') }}" class="btn btn-secondary ml-2">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel User -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><b>DAFTAR PENGGUNA</b></h3>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="mb-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <label>Show</label>
                        <select onchange="location = this.value;" class="form-control d-inline-block w-auto ml-2">
                            <option value="{{ route('admin.user.index', array_merge(request()->all(), ['per_page' => 10])) }}" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                            <option value="{{ route('admin.user.index', array_merge(request()->all(), ['per_page' => 25])) }}" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="{{ route('admin.user.index', array_merge(request()->all(), ['per_page' => 50])) }}" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        </select>
                        <span class="ml-2">records</span>
                    </div>
                </div>
            </div>

            <!-- Tabel User -->
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIK</th>
                        <th>KK</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No Hp</th>
                        <th>Level</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            {{-- <td>{{ $loop->iteration }}</td> --}}
                            <td>{{ $users->firstItem() + $loop->index }}</td>
                            <td>
                                {{ $user->nik }}
                                <br>
                                @if($user->active == 1)
                                    <span class="badge badge-success">Aktif</span>
                                @elseif($user->active == 2)
                                    <span class="badge badge-warning">Diblokir</span>
                                @else
                                    <span class="badge badge-danger">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>{{ $user->kk }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->level_name }}</td>
                            <td>
                                <!-- Tombol Edit: Buka Modal -->
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editUserModal"
                                        data-id="{{ $user->id }}"
                                        data-nik="{{ $user->nik }}"
                                        data-kk="{{ $user->kk }}"
                                        data-name="{{ $user->name }}"
                                        data-email="{{ $user->email }}"
                                        data-phone="{{ $user->phone }}"
                                        data-level="{{ $user->role_id ?? ''}}" 
                                        data-kecamatan="{{ $user->id_kec ?? '' }}"
                                        data-desa_kel="{{ $user->kode_desa ?? '' }}">
                                    Edit
                                </button>

                                <!-- Tombol Blokir -->
                                <form action="{{ route('admin.user.blokir', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin memblokir user ini?')">Blokir</button>
                                </form>

                                <!-- Tombol Reset Password -->
                                <form action="{{ route('admin.user.resetPassword', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Apakah Anda yakin ingin me-reset password pengguna {{ $user->name }} menjadi \'pondokdukcapil\'?')">Reset</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} results
                </div>
                <div>
                    {{ $users->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit User (DI LUAR TABEL!) -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editUserForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="editUserId">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>NIK</label>
                                <input type="text" name="nik" id="editNik" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>KK</label>
                                <input type="text" name="kk" id="editKk" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" name="name" id="editName" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" id="editEmail" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>No Hp</label>
                                <input type="text" name="phone" id="editPhone" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Level</label>
                                <select name="role_id" id="editLevelId" class="form-control" required>
                                    <option value="">Pilih Level</option>
                                    @foreach($levels as $level)
                                        <option value="{{ $level->id }}">{{ $level->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- Kecamatan -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kecamatan</label>
                                <select name="id_kec" id="editKecamatanId" class="form-control" required>
                                    <option value="">Pilih Kecamatan</option>
                                    @foreach($kecamatans as $kec)
                                        <option value="{{ $kec->id }}">{{ $kec->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- Desa/Kelurahan -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Desa / Kelurahan</label>
                                <select name="kode_desa" id="editDesaKelId" class="form-control" required>
                                    <option value="">Pilih Desa/Kel</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" form="editUserForm" class="btn btn-primary">Edit</button>
            </div>
        </div>
    </div>
</div>

@section('js')
<script>
$(document).ready(function() {

    // ===================================================================
    // 1. FUNGSI UTAMA UNTUK MEMUAT DATA DESA (Sudah Benar)
    // ===================================================================
    function loadDesaForEdit(kecamatanId, selectedDesaId = '') {
        var $desaSelect = $('#editDesaKelId');
        
        // Reset dropdown Desa
        $desaSelect.html('<option value="">Pilih Desa/Kel</option>');
        $desaSelect.prop('disabled', true);

        if (kecamatanId) {
            // Gunakan jQuery AJAX, lebih konsisten dengan $(document).ready
            $.ajax({
                url: `/admin/desa?kecamatan_id=${encodeURIComponent(kecamatanId)}`,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    data.forEach(desa => {
                        var option = new Option(desa.nama, desa.kode_desa);
                        $desaSelect.append(option);
                        // Console log untuk debugging (Bagus, dipertahankan)
                        // console.log(`Opsi ditambahkan: ${desa.nama} (Value: ${desa.kode_desa})`);
                    });
                    
                    $desaSelect.prop('disabled', false);

                    if (selectedDesaId) {
                        $desaSelect.val(selectedDesaId);
                        // Console log konfirmasi set value (Bagus, dipertahankan)
                        // console.log('✅ Desa terpilih:', selectedDesaId);
                        // console.log('Nilai Desa setelah mencoba set:', $desaSelect.val());
                    }
                },
                error: function(error) {
                    console.error('❌ Error saat memuat data desa:', error);
                    $desaSelect.prop('disabled', false);
                }
            });
        } else {
            $desaSelect.prop('disabled', false);
        }
    }


    // ===================================================================
    // 2. LOGIKA MODAL (INITIAL LOAD)
    // ===================================================================
    $('#editUserModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var role_id = button.data('level') || '';
        var kecamatanId = button.data('kecamatan') || '';
        var desaKelId = button.data('desa_kel') || '';

        var modal = $(this);
        
        // Mengisi data text input (Sudah Benar)
        modal.find('#editUserId').val(id);
        modal.find('#editNik').val(button.data('nik'));
        modal.find('#editKk').val(button.data('kk'));
        modal.find('#editName').val(button.data('name'));
        modal.find('#editEmail').val(button.data('email'));
        modal.find('#editPhone').val(button.data('phone'));

        // Mengisi Level
        $('#editLevelId').val(role_id); 

        // Mengisi Kecamatan
        $('#editKecamatanId').val(kecamatanId);
        
        // Set URL form
        var updateUrl = '{{ route("admin.user.update", ":id") }}'.replace(':id', id);
        $('#editUserForm').attr('action', updateUrl);

        // Muat desa dengan nilai yang sudah ada
        loadDesaForEdit(kecamatanId, desaKelId);
    });

    
    // ===================================================================
    // 3. EVENT LISTENER UNTUK PERUBAHAN DI MODAL
    // ===================================================================
    
    // a) Saat Kecamatan diubah: Reset Desa & Muat Baru
    $(document).on('change', '#editKecamatanId', function() {
        var kecamatanId = $(this).val();
        var $desaSelect = $('#editDesaKelId');
        
        // Hapus nilai desa yang lama agar tidak terbawa saat submit
        $desaSelect.val(''); 
        
        console.log('🔄 Kecamatan diubah:', kecamatanId);
        
        // Muat Desa baru (tanpa selectedDesaId, karena ini perubahan manual)
        loadDesaForEdit(kecamatanId);
    });

    // b) SOLUSI PENTING: Saat Desa diubah: Kunci Nilainya (Memastikan Nilai Terkirim)
    $(document).on('change', '#editDesaKelId', function() {
        var desaKelId = $(this).val();
        
        // Secara eksplisit set nilai kembali ke elemen untuk memastikan DOM merekamnya
        $(this).val(desaKelId); 
        console.log('✅ Desa dipilih manual, nilai diset:', desaKelId);
    });


    // ===================================================================
    // 4. SCRIPT FILTER & DROPDOWN UTAMA (DI LUAR MODAL)
    // ===================================================================
    
    // Fungsi load desa untuk filter utama (di luar modal)
    function loadDesaForFilter(kecamatanId, currentDesa = '') {
        var $desaSelect = $('select[name="desa_kel"]');
        $desaSelect.html('<option value="">Pilih Desa/Kel</option>');
        $desaSelect.prop('disabled', true);

        if (kecamatanId) {
            $.ajax({
                url: `/admin/desa?kecamatan_id=${encodeURIComponent(kecamatanId)}`,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    data.forEach(desa => {
                        var option = new Option(desa.nama, desa.kode_desa);
                        $desaSelect.append(option);
                    });
                    $desaSelect.prop('disabled', false);
                    if (currentDesa) $desaSelect.val(currentDesa);
                },
                error: function() {
                    $desaSelect.prop('disabled', false);
                }
            });
        } else {
            $desaSelect.prop('disabled', false);
        }
    }
    
    // Event change kecamatan di filter utama
    $('select[name="kecamatan"]').on('change', function () {
        var kecamatanId = $(this).val();
        var currentDesa = "{{ request('desa_kel') }}";
        loadDesaForFilter(kecamatanId, currentDesa);
    });

    // Pemicu load desa saat halaman dimuat jika filter kecamatan sudah ada
    var currentKecamatan = "{{ request('kecamatan') }}";
    if (currentKecamatan) {
        $('select[name="kecamatan"]').trigger('change');
    }
});
</script>
@stop

@endsection