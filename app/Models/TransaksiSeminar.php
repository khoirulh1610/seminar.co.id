<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;

class TransaksiSeminar extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $casts = [
        'list' => AsArrayObject::class,
        'mutasi_payload' => AsArrayObject::class
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'kode_event', 'kode_event');
    }

    public function product()
    {
        return $this->belongsTo(Produk::class, 'name', 'produk');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'phone', 'ref');
    }
}
