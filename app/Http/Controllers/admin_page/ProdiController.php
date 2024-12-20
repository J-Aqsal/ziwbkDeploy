<?php

namespace App\Http\Controllers\admin_page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Prodi;
use App\Models\Admin\Jurusan;

class ProdiController extends Controller
{
  public function index()
  {
    return view('admin-page.prodi.prodi');
  }

  public function getProdi () {
    // Mengambil semua data di model mahasiswa beserta function prodi
    $prodi = Prodi::with('jurusan')->get();
    return response()->json(['data' => $prodi]); // ini ke admin/mahasiswa.js
  }

  public function getJurusan() // New method for jurusan data
  {
      $jurusan = Jurusan::all(); // Fetch all jurusan data
      return response()->json($jurusan);

  }

  public function store(Request $request)
  {
      // Validasi data yang dikirimkan
      $validatedData = $request->validate([
          'nama' => 'required|unique:prodi,nama',
          'id_jurusan' => 'required|uuid',
      ], [
        'nama.unique' => 'Prodi sudah terdaftar.'
      ]
    );

      // Simpan data ke tabel jurusan
      $prodi = new Prodi();
      $prodi->nama = $validatedData['nama'];
      $prodi->id_jurusan = $validatedData['id_jurusan'];
      $prodi->save();

      // Response JSON sukses
      return response()->json([
          'message' => 'Prodi berhasil ditambahkan!',
          'data' => $prodi
      ]);
  }

  public function update(Request $request) {
    $request->validate([
        'id' => 'required|exists:prodi,id',
        'nama' => 'required|string|max:255',
        'id_jurusan' => 'required|uuid',
    ]);

    $prodi = Prodi::find($request->id);
    $prodi->nama = $request->nama;
    $prodi->id_jurusan = $request->id_jurusan;
    $prodi->save();

    return response()->json(['message' => 'Prodi updated successfully!']);
}

public function destroy($id)
{
    // Cari jurusan yang ingin dihapus
    $prodi = Prodi::findOrFail($id);
    $prodi->delete();

    // Response JSON sukses
    return response()->json([
        'message' => 'Prodi berhasil dihapus!'
    ]);
}
}
