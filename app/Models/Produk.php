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
    ];

    public function scopeTerlaris($query)
    {
        return $query->addSelect([
            'popularity' => DetailTransaksi::whereColumn('produk_id', 'produks.id')->where('status', 'checkout')->selectRaw('COUNT(id)'),
        ])
        ->orderByDesc('popularity');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}
