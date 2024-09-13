<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function tambah_ruangan()
    {
        return view('admin.tambah_ruangan');
    }

    public function tambah_data(Request $request)
    {
        $request->validate([
            'nama_ruangan' => 'required|string|max:255',
            'jenis_ruangan' => 'required|string|max:255',
            'harga' => 'required|integer',
            'fasilitas' => 'required|string',
            'deskripsi' => 'nullable|string',
            'jumlah' => 'required|integer',
            'kapasitas' => 'required|integer',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $room = new Room();
        $room->nama_ruangan = $request->nama_ruangan;
        $room->jenis_ruangan = $request->jenis_ruangan;
        $room->harga = $request->harga;
        $room->fasilitas = $request->fasilitas;
        $room->deskripsi = $request->deskripsi;
        $room->jumlah = $request->jumlah;
        $room->kapasitas = $request->kapasitas;

        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $room->gambar = $imageName;
        }

        $room->save();

        return redirect()->back()->with('success', 'Room added successfully.');
    }

    public function lihat_ruangan()
    {
        $data = Room::all(); 
        return view('admin.lihat_ruangan', ['data' => $data]);
    }
}
