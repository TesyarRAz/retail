<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = new \stdClass;

        $data->pesanan_baru = \App\Models\Transaksi::whereDate('created_at', now())->count();
        $data->new_user = \App\Models\User::whereDate('created_at', now())->count();

        return view('admin.dashboard.index', compact('data'));
    }
}
