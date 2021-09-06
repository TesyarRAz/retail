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
    public function index(Request $request)
    {
        if (!in_array($request->type, ['keranjang', 'checkout', 'selesai']))
        {
            return redirect()->route('customer.keranjang.index', ['type' => 'keranjang']);
        }

        if ($request->type == 'keranjang')
        {
            $datas = auth()->user()->keranjangs()->select('detail_transaksis.*')->with('produk')->get();
        }
        else if ($request->type == 'checkout')
        {
            $datas = auth()->user()->checkouts;
        }
        else if ($request->type == 'selesai')
        {
            $datas = auth()->user()->transaksis()->where('selesai', true)->get();
        }

        return view('customer.keranjang.index', compact('datas'));
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

        $data = $request->validate([
            'jenis' => 'required|in:diambil,dikirim',
            'pengiriman_via' => 'required_if:jenis,dikirim',
            'alamat_pengiriman' => 'required_if:jenis,dikirim',
        ]);

        $data['invoice'] = strtoupper(\Str::random(10));
        $data['price_total'] = $total;

        $transaksi = auth()->user()->transaksis()->create($data);

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
    public function update(Request $request, Transaksi $keranjang)
    {
        if ($request->type == 'bukti')
        {
            $data = $request->validate([
                'bukti_transaksi' => 'required|file|image|max:1024',
            ]);

            $data['bukti_transaksi'] = $request->bukti_transaksi->storeAs(
                'user/' . auth()->user()->username . '/image',
                \Str::random(40) . '.' . $request->bukti_transaksi->getClientOriginalExtension(),
                'public',
            );

            $data['keterangan_ditolak'] = null;

            $keranjang->update($data);

            return redirect()->route('customer.keranjang.index', ['type' => 'checkout'])->with('status', 'Transaksi anda sedang di proses');
        }
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
