<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class SlideController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.only'); // Hanya bisa diakses oleh Admin
    }

    /**
     * Memastikan tabel slides ada & menampilkan halaman daftar slide
     */
    public function index()
    {
        self::ensureSlidesTableExists();

        $slides = Slide::orderBy('id', 'asc')->get();
        return view('admin.slide.index', compact('slides'));
    }

    /**
     * Memperbarui salah satu gambar slide (ID 1 - 4)
     */
    public function update(Request $request, $id)
    {
        $slide = Slide::findOrFail($id);

        $request->validate([
            'judul' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|dimensions:width=1280,height=720|max:5120',
            'aktif' => 'required|in:Y,N',
        ], [
            'image.dimensions' => 'Gambar harus memiliki dimensi tepat 1280 x 720 piksel.',
            'image.max'        => 'Ukuran gambar tidak boleh melebihi 5 MB.',
        ]);

        $slide->judul = $request->judul;
        $slide->aktif = $request->aktif;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            
            // Hapus gambar lama jika ada dan bukan gambar default bawaan awal
            $oldPath = public_path('images/' . $slide->filename);
            if (file_exists($oldPath) && !in_array($slide->filename, ['1.jpg', '2.jpg', '3.jpg', '4.jpg'])) {
                @unlink($oldPath);
            }

            // Nama file baru menggunakan timestamp agar langsung membersihkan cache browser
            $filename = 'slide_' . $id . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Pindahkan file ke public/images/
            $file->move(public_path('images'), $filename);
            
            $slide->filename = $filename;
        }

        $slide->save();

        return redirect()
            ->route('admin.slide.index')
            ->with('success', 'Gambar Slide ' . $id . ' berhasil diperbarui.');
    }

    /**
     * Helper static untuk memastikan tabel & seeder slides siap
     */
    public static function ensureSlidesTableExists()
    {
        if (!Schema::hasTable('slides')) {
            Schema::create('slides', function ($table) {
                $table->integer('id')->primary();
                $table->string('filename', 100);
                $table->string('judul', 100)->nullable();
                $table->char('aktif', 1)->default('Y');
            });

            // Seeding default slides 1.jpg sd 4.jpg
            for ($i = 1; $i <= 4; $i++) {
                Slide::create([
                    'id'       => $i,
                    'filename' => $i . '.jpg',
                    'judul'    => 'Maklumat ' . $i,
                    'aktif'    => 'Y',
                ]);
            }
        }
    }
}
