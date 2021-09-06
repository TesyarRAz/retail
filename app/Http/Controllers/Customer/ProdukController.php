<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('store');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Produk::query()
            ->when($request->has('search'), fn($query) => $query->where('name', 'like', '%' . $request->search . '%'))
            ->when($request->has('kategori'), fn($query) => $query->whereHas('kategori', fn($query) => $query->where('name', $request->kategori)))
            ->with('kategori')
            ->cursorPaginate(20);

        return view('customer.produk.index', compact('data'));
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
        $data = $request->validate([
            'produk_id' => 'required',
            'qty' => 'required|numeric',
        ]);

        $produk = Produk::findOrFail($data['produk_id']);

        $detail = auth()->user()->keranjangs()->firstOrNew(\Arr::only($data, ['produk_id']));

        $detail->qty = ($detail->qty ?? 0) + $data['qty'];
        $detail->price_total = $detail->qty * $produk->price;
        $detail->save();

        if ($request->type == 'checkout')
        {
            return redirect()->route('customer.keranjang.index');
        }
        else if ($request->type == 'keranjang')
        {
            return back()->with('status', 'Berhasil masukan ke keranjang');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function show(Produk $produk)
    {
        $produk->load('kategori');

        return view('customer.produk.show', compact('produk'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function edit(Produk $produk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Produk $produk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produk $produk)
    {
        //
    }
}
