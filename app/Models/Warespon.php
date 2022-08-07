<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Warespon extends Model
{
    use HasFactory;

    protected $table = 'template_warespon';

    public static function init($tb = null)
    {
        if ($tb) {
            $cektable = Schema::hasTable($tb);
            if (!$cektable) {
                DB::statement("create table " . $tb . " like template_warespon");
            }
        } elseif (Auth::user()) {
            $tb = "user" . Auth::id() . "_warespon";
            $cektable = Schema::hasTable($tb);
            if (!$cektable) {
                DB::statement("create table " . $tb . " like template_warespon");
            }
        } else {
            return false;
        }
        return true;
    }
}
