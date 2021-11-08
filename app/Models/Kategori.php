<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'gambar' => 'App\Casts\PublicFileCast',
    ];

    public function produks()
    {
        return $this->hasMany(Produk::class);
    }
}
