<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Produk;
use App\Models\Kategori;

class HomeController extends Controller
{
    public function index()
    {
        if (auth()->check())
        {
            if (auth()->user()->role == 'admin')
            {
                return redirect()->route('admin.dashboard.index');
            }
        }

        $kategoris = Kategori::all();

        $terlaris = Produk::terlaris()->with('kategori')->take(5)->get();
        $terbaru = Produk::latest()->with('kategori')->take(5)->get();

        return view('home', compact('terlaris', 'terbaru', 'kategoris'));
    }
}
