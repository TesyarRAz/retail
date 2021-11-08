<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Kategori;
use Illuminate\Http\Request;

class TransaksiController extends Controller
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
                Transaksi::select('transaksis.*')
                ->where(fn($query) => 
                    $query->where(fn($query) => 
                        $query->where('jenis', 'diambil')->whereNotNull('bukti_transaksi')
                    )
                    ->orWhere('jenis', 'dikirim')
                )
                ->with('details', 'user')
                ->when($request->has('kategori_id') && $request->kategori_id != -1, fn($query) =>
                    $query->whereHas('details.produk', fn($query) => $query->where('kategori_id', $request->kategori_id))
                )
                ->when($request->has('status'), fn($query) => $query
                    ->when($request->status == 'selesai', fn($query) => $query->where('selesai', true))
                    ->when($request->status == 'ditolak', fn($query) => $query->whereNotNull('keterangan_ditolak'))
                    ->when($request->status == 'ongkir', fn($query) => $query->where('jenis', 'dikirim')->whereNull('ongkir'))
                    ->when($request->status == 'bukti', fn($query) => $query->whereNull('bukti_transaksi'))
                    ->when($request->status == 'konfirmasi', fn($query) => $query->whereNotNull('bukti_transaksi')->whereNull('keterangan_ditolak'))
                )
                ->latest(),
            )
            ->editColumn('price_total', function($row) {
                return number_format($row->price_total, 0, ',', '.');
            })
            ->editColumn('bukti_transaksi', function($row) {
                $url = $row->bukti_transaksi;

                if (blank($url))
                {
                    return 'Tidak ada';
                }

                return <<< blade
                <a href="$url" target="_blank" class="btn btn-sm btn-primary">Buka</a>
                blade;
            })
            ->editColumn('created_at', function($row) {
                return $row->created_at->format('d-m-Y');
            })
            ->addColumn('status', function($row) {
                if ($row->selesai)
                {
                    return '<span class="badge badge-primary">Selesai</span>';
                }

                if ($row->keterangan_ditolak)
                {
                    return '<span class="badge badge-danger">Ditolak</span>';
                }

                if ($row->jenis == 'dikirim' && blank($row->ongkir))
                {
                    return '<span class="badge badge-danger">Ongkir belum diatur</span>';
                }

                if (blank($row->bukti_transaksi))
                {
                    return '<span class="badge badge-danger">Bukti transaksi belum dikirim</span>';
                }

                return '<span class="badge badge-success">Menunggu Dikonfirmasi</span>';
            })
            ->addColumn('aksi', function($row) {
                $id = $row->id;

                $csrf = csrf_field();
                $delete = method_field('delete');

                $show_route = route('admin.transaksi.show', $id);
                $delete_route = route('admin.transaksi.destroy', $id);

                $disable_tolak = $row->selesai ? 'disabled' : '';

                return <<< blade
                <a class="btn btn-sm btn-primary mb-1" href="$show_route">
                    <i class="fas fa-fw fa-book"></i>
                    Invoice
                </a>
                <button class="btn btn-sm mb-1 btn-danger" type="button" onclick="tolak('$id')" $disable_tolak>
                    <i class="fas fa-fw fa-trash"></i>
                    Tolak
                </button>
                blade;
            })
            ->addIndexColumn()
            ->rawColumns(['bukti_transaksi', 'status', 'aksi'])
            ->make(true);
        }

        $datatable = app('datatables.html')
        ->columns([
            [
                'data' => 'user.name',
                'title' => 'Name',
            ],
            [
                'data' => 'invoice',
                'title' => 'Invoice',
            ],
            [
                'data' => 'created_at',
                'title' => 'Tanggal',
            ],
            [
                'data' => 'price_total',
                'title' => 'Total Belanja',
            ],
            [
                'data' => 'bukti_transaksi',
                'title' => 'Bukti Transaksi',
            ],
            [
                'data' => 'status',
                'title' => 'Status',
                'searchable' => false,
                'orderable' => false,
            ],
            [
                'title' => 'Aksi',
                'data' => 'aksi',
                'searchable' => false,
                'orderable' => false,
            ]
        ])
        ->ajaxWithForm(null, '#form-filter-kategori')
        ->orderBy(0);

        $kategoris = Kategori::all();

        return view('admin.transaksi.index', compact('datatable', 'kategoris'));
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
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Transaksi $transaksi)
    {
        if ($request->ajax())
        {
            return response($transaksi);
        }

        return view('admin.transaksi.show', compact('transaksi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaksi $transaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        if ($request->type == 'tolak')
        {
            $data = $request->validate([
                'keterangan_ditolak' => 'required',
            ]);

            $data['selesai'] = false;

            $transaksi->update($data);

            return back()->with('status', 'Berhasil melakukan penolakan');
        }

        if ($request->type == 'konfirmasi')
        {
            $transaksi->update([
                'selesai' => true
            ]);

            return redirect()->route('admin.transaksi.index')->with('status', 'Berhasil melakukan konfirmasi');
        }

        if ($request->type == 'ongkir')
        {
            $data = $request->validate([
                'ongkir' => 'required',
            ]);
            
            $transaksi->update($data);

            return back()->with('status', 'Berhasil mengatur ongkir');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaksi $transaksi)
    {
        try
        {
            $transaksi->delete();
        }
        catch (\Exception $ex)
        {
            return back()->with('status', 'Gagal hapus transaksi');
        }

        return back()->with('status', 'Berhasil hapus transaksi');
    }
}
