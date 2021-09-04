<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'price' => 'App\Casts\MaskMoneyCast',
        'image' => 'App\Casts\PublicFileCast',
    ];

    public function scopeTerlaris($query)
    {
        return $query->addSelect([
            'popularity' => DetailTransaksi::whereColumn('produk_id', 'produks.id')->whereHas('transaksi', fn($query) => $query->where('selesai', true)->selectRaw('COUNT(id)'),
        ])
        ->orderByDesc('popularity');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}
