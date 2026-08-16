<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use Illuminate\Http\Request;

class DesaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Desa::query();

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $desas = $query->latest()->paginate(10)->withQueryString();

        // Data Statistik
        $totalDesa = Desa::count();
        $desaBulanIni = Desa::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        return view('admin.master_desa.index', compact(
            'desas',
            'totalDesa',
            'desaBulanIni'
        ));
    }
    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:desas,nama',
        ]);

        Desa::create([
            'nama' => $request->nama,
        ]);

        return redirect()->route('admin.desa.index')->with('success', 'Data desa berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(string $id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $desa = Desa::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255|unique:desas,nama,' . $desa->id,
        ]);

        $desa->update([
            'nama' => $request->nama,
        ]);

        return redirect()->route('admin.desa.index')->with('success', 'Data desa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $desa = Desa::findOrFail($id);
        $desa->delete();

        return redirect()->route('admin.desa.index')->with('success', 'Data desa berhasil dihapus.');
    }
}
