<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Seminar;

class Event extends Model
{
    use HasFactory;

    public function seminar()
    {
        return $this->hasMany(Seminar::class, 'kode_event','kode_event');
    }
}
