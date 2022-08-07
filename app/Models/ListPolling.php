<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListPolling extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function scopeGroup($query, string $group)
    {
        return $query->where('group', $group);
    }
}
