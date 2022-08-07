<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeCheckToday($query, $id_peserta)
    {
        return $query->where('seminar_id', $id_peserta)
            ->whereDate('created_at', Carbon::now())->first();
    }

    public function scopeToday($query, $event_kode)
    {
        return $query->where('kode_event', $event_kode)
            ->whereDate('created_at', Carbon::now())
            ->orderBy('created_at', 'DESC');
    }

    public function seminar()
    {
        return $this->belongsTo(Seminar::class);
    }
}
