<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Seminar extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $dates = ['deleted_at'];

    public function pengundang()
    {
        return $this->belongsTo(self::class,'ref','phone');
    }

    public function rangking()
    {
        return $this->hasMany(self::class,'ref','phone');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'ref','phone');
    }


}
