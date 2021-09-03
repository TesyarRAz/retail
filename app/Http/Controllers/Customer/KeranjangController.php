<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keranjangs = auth()->user()->keranjangs()->select('detail_transaksis.*')->with('produk')->get();

        return view('customer.keranjang.index', compact('keranjangs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DetailTransaksi  $keranjang
     * @return \Illuminate\Http\Response
     */
    public function show(DetailTransaksi $keranjang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DetailTransaksi  $keranjang
     * @return \Illuminate\Http\Response
     */
    public function edit(DetailTransaksi $keranjang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DetailTransaksi  $keranjang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DetailTransaksi $keranjang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DetailTransaksi  $keranjang
     * @return \Illuminate\Http\Response
     */
    public function destroy(DetailTransaksi $keranjang)
    {
        $this->authorize('delete', $keranjang);

        $keranjang->delete();

        return back()->with('status', 'Berhasil hapus dari keranjang');
    }
}
