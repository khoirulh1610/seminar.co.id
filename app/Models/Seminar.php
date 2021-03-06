<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use Carbon\Carbon;

class Seminar extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];
    protected $casts = [
        'absen_at' => 'datetime'
    ];

    public function pengundang()
    {
        return $this->belongsTo(self::class, 'ref', 'phone');
    }

    public function rangking()
    {
        return $this->hasMany(self::class, 'ref', 'phone');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'ref', 'phone');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'kode_event', 'kode_event');
    }

    public function scopeWithAbsen($query, $kode_event)
    {
        return $query->with('absen')->where('kode_event', $kode_event);
    }

    public function absen()
    {
        return $this->hasOne(Absensi::class);
    }

    public function scopePhone($query, $phone)
    {
        $phone = preg_replace('/^0/', 62, $phone);
        return $query->where('phone', $phone);
    }
}
