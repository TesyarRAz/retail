<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
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
                Kategori::query()
            )
            ->addColumn('aksi', function($row) {
                $id = $row->id;

                $csrf = csrf_field();
                $delete = method_field('delete');

                $delete_route = route('admin.kategori.destroy', $id);

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
            ->rawColumns(['aksi'])
            ->make(true);
        }

        $datatable = app('datatables.html')
        ->columns([
            [
                'data' => 'name',
                'title' => 'Name',
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

        return view('admin.kategori.index', compact('datatable'));
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
        ]);

        if ($request->hasFile('gambar'))
        {
            $data['gambar'] = $request->gambar->storeAs(
                'user/' . auth()->user()->username . '/image',
                \Str::random(40) . '.' . $request->gambar->getClientOriginalExtension(),
                'public',
            );
        }

        Kategori::create($data);

        return back()->with('status', 'Berhasil tambah kategori');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function show(Kategori $kategori)
    {
        return response($kategori);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function edit(Kategori $kategori)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kategori $kategori)
    {
        $data = $request->validate([
            'name' => 'required',
        ]);

        if ($request->hasFile('gambar'))
        {
            $data['gambar'] = $request->gambar->storeAs(
                'user/' . auth()->user()->username . '/image',
                \Str::random(40) . '.' . $request->gambar->getClientOriginalExtension(),
                'public',
            );
        }

        $kategori->update($data);

        return back()->with('status', 'Berhasil edit kategori');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kategori $kategori)
    {
        try
        {
            $kategori->delete();
        }
        catch (\Exception $ex)
        {
            return back()->with('status', 'Gagal hapus kategori');
        }

        return back()->with('status', 'Berhasil hapus kategori');
    }
}
