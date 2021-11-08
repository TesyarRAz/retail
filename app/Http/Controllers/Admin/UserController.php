<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
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
                User::whereNotIn('id', [auth()->user()->id])
                    ->withCount('transaksis')
            )
            ->addColumn('aksi', function($row) {
                $id = $row->id;

                $csrf = csrf_field();
                $delete = method_field('delete');

                $delete_route = route('admin.user.destroy', $id);

                return <<< blade
                <!-- <button class="btn btn-sm mb-1 btn-primary" onclick="edit('$id')">
                    <i class="fas fa-fw fa-book"></i>
                    Edit
                </button> --!>
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
                'data' => 'email',
                'title' => 'Email',
            ],
            [
                'data' => 'username',
                'title' => 'Username',
            ],
            [
                'data' => 'transaksis_count',
                'title' => 'Total Transaksi',
                'orderable' => false,
                'searchable' => false,
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

        return view('admin.user.index', compact('datatable'));
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try
        {
            $user->delete();
        }
        catch (\Exception $ex)
        {
            return back()->with('status', 'Gagal hapus user');
        }

        return back()->with('status', 'Berhasil hapus user');
    }
}
