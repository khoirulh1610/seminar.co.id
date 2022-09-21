<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Antrian extends Model
{
    use HasFactory;
    protected $table = "antrians";
    protected $guarded = ['id'];

    public function __construct()
    {
        $tb = "zu" . Auth::id() . "_antrians";
        $cektable = Schema::hasTable($tb);
        if (!$cektable) {
            DB::statement("create table " . $tb . " like antrians");
        }
        $this->table = $tb;
    }
}
