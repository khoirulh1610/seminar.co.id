<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    /**
     * Get all user joined in mitra
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }


    public function leader()
    {
        return $this->belongsTo(User::class, 'user_leader', 'id');
    }


    public function produks()
    {
        return $this->hasMany(Produk::class);
    }


    public static function findMitra($mitra): Mitra
    {
        if ($mitra instanceof Mitra) {
            $m = $mitra;
        } else if (!is_numeric($mitra)) {
            $m = Mitra::firstWhere('kode_mitra', $mitra);
            if (!$m) throw new Exception("Tidak ada kode_mitra = {$mitra} ", 500);
        } else {
            $m = Mitra::find($mitra);
            if (!$m) throw new Exception("Tidak ada mitra dengan id = {$mitra} ", 500);
        }
        return $m;
    }
}
