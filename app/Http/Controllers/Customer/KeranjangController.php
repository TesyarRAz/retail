<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\DetailTransaksi;
use App\Models\Transaksi;
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
        $checkouts = auth()->user()->checkouts;

        return view('customer.keranjang.index', compact('keranjangs', 'checkouts'));
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
        $total = auth()->user()->keranjangs->sum('price_total');

        $transaksi = auth()->user()->transaksis()->create([
            'invoice' => \Str::random(10),
            'price_total' => $total,
        ]);

        $transaksi->details()->saveMany(auth()->user()->keranjangs);

        return redirect()->route('customer.keranjang.show', $transaksi->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaksi  $keranjang
     * @return \Illuminate\Http\Response
     */
    public function show(Transaksi $keranjang)
    {
        return view('customer.keranjang.show', [
            'transaksi' => $keranjang
        ]);
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
        $data = $request->validate([
            'bukti_transaksi' => 'required|file|image',
        ]);

        $data['bukti_transaksi'] = $request->bukti_transaksi->storeAs(
            'user/' . auth()->user()->username . '/image',
            \Str::random(40) . '.' . $request->bukti_transaksi->getClientOriginalExtension(),
            'public',
        );

        $keranjang->update($data);

        return redirect()->route('home')->with('status', 'Transaksi anda sedang di proses');
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
