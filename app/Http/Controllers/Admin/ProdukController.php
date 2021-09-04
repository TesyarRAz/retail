<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            return datatables()->of(
                auth()->user()->produks()->latest()
            )
            ->editColumn('price', function($row) {
                return number_format($row->price, 0, ',', '.');
            })
            ->editColumn('image', function($row) {
                $url = $row->image;

                return <<< blade
                <img src="$url" class="img-thumbnail" width="100" height="100">
                blade;
            })
            ->addColumn('aksi', function($row) {
                $id = $row->id;

                $csrf = csrf_field();
                $delete = method_field('delete');

                $delete_route = route('admin.produk.destroy', $id);

                return <<< blade
                <button class="btn btn-sm mb-1 btn-primary" onclick="edit('$id')">
                    <i class="fas fa-fw fa-book"></i>
                    Edit
                </button>
                <button class="btn btn-sm mb-1 btn-danger" onclick="$('#form-delete-$id').submit()">
                    <i class="fas fa-fw fa-trash"></i>
                    Hapus
                </button>
                <form class="d-none" action="$delete_route" method="post" id="form-delete-$id" onsubmit="return confirm('Yakin ingin dihapus?')">
                    $csrf
                    $delete
                </form>
                blade;
            })
            ->addIndexColumn()
            ->rawColumns(['image', 'aksi'])
            ->make(true);
        }

        $datatable = app('datatables.html')
        ->columns([
            [
                'data' => 'name',
                'title' => 'Name',
            ],
            [
                'data' => 'price',
                'title' => 'Harga',
            ],
            [
                'data' => 'image',
                'title' => 'Gambar',
            ],
            [
                'title' => 'Aksi',
                'data' => 'aksi',
                'searchable' => false,
                'orderable' => false,
            ]
        ])
        ->orderBy(0)
        ->minifiedAjax();

        $kategoris = Kategori::all();

        return view('admin.produk.index', compact('datatable', 'kategoris'));
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
            'name' => 'required',
            'price' => 'required',
            'image' => 'required|file|image',
            'kategori_id' => 'required|exists:kategoris,id',
            'description' => 'bail',
        ]);

        $data['image'] = $request->image->storeAs(
            'user/' . auth()->user()->username . '/image',
            \Str::random(40) . '.' . $request->image->getClientOriginalExtension(),
            'public',
        );

        auth()->user()->produks()->create($data);

        return back()->with('status', 'Berhasil membuat produk');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function show(Produk $produk)
    {
        return response($produk);
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
        $data = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'image' => 'file|image',
            'kategori_id' => 'required|exists:kategoris,id',
            'description' => 'bail',
        ]);

        if ($data['image'] != null)
        {
            $data['image'] = $request->image->storeAs(
                'user/' . auth()->user()->username . '/image',
                \Str::random(40) . '.' . $request->image->getClientOriginalExtension(),
                'public',
            );
        }
        else
        {
            unset($data['image']);
        }

        $produk->update($data);

        return back()->with('status', 'Berhasil membuat produk');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produk $produk)
    {
        try
        {
            $produk->delete();
        }
        catch (\Exception $ex)
        {
            return back()->with('status', 'Gagal hapus produk');
        }

        return back()->with('status', 'Berhasil hapus produk');
    }
}
