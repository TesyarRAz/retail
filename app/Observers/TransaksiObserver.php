<?php

namespace App\Observers;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;

class TransaksiObserver
{
    /**
     * Handle the Transaksi "created" event.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return void
     */
    public function created(Transaksi $transaksi)
    {
        //
    }

    /**
     * Handle the Transaksi "updated" event.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return void
     */
    public function updated(Transaksi $transaksi)
    {
        //
    }

    /**
     * Handle the Transaksi "deleting" event.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return void
     */
    public function deleting(Transaksi $transaksi)
    {
        DetailTransaksi::destroy($transaksi->details()->pluck('id'));
    }

    /**
     * Handle the Transaksi "restored" event.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return void
     */
    public function restored(Transaksi $transaksi)
    {
        //
    }

    /**
     * Handle the Transaksi "force deleted" event.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return void
     */
    public function forceDeleted(Transaksi $transaksi)
    {
        //
    }
}
