<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Seminar;

class Event extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $casts = [
        'tgl_event' => 'datetime'
    ];

    protected $hidden = [
        "event_detail",
        "cw_register",
        "cw_register2",
        "cw_payment",
        "cw_referral",
        "cw_payment_ref",
        "cw_email_register",
        "cw_email_payment",
        "cw_bayar",
        "cw_tagihan",
        "cw_absen",
        "cw_absen_ref",
        "cw_facebook",
        "flayer_facebook",
        "cw_instagram",
        "flayer_instagram",
        "notif_register",
        "harga_2",
        "harga_3",
        "harga_4",
        "harga_5",
        "fee_referral",
        "fee_admin",
        "jadwal_flye",
        "jam_flyer",
        "pin",
        "notifikasi",
        "device_id",
        "notifikasi_host",
        "notifikasi_key",
        "notifikasi_att1",
        "reg_absen",
        "login_ref",
        "zoom_id",
        "required_ref",
        "group_info",
        "cw_fb",
        "cw_ig",
        "flayer_fb",
        "flayer_ig",
        "komisi_mitra",
        "user_id",
        "mitra_id"
    ];

    public function getPengundangAttribute()
    {
        return $this->user->nama ?? '';
    }

    public function seminar()
    {
        return $this->hasMany(Seminar::class, 'kode_event', 'kode_event');
    }

    public function seminars()
    {
        return $this->belongsTo(Seminar::class, 'kode_event', 'kode_event');
    }

    public function event()
    {
        return $this->hasMany(TransaksiSeminar::class, 'kode_event', 'kode_event');
    }

    public function product()
    {
        return $this->belongsTo(Produk::class, 'produk', 'name');
    }
}
