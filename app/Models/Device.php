<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Antrian;

class Device extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function antrian()
    {
        return $this->hasMany(Antrian::class,'device_id','id');
    }

    public function server()
    {
        return $this->belongsTo(Server::class);
    }
}
