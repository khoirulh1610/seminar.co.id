<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Role;
use Carbon\Carbon;
use Exception;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    //     'device_token',
    // ];

    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }




    /**
     * Mitra Relations
     */
    public function mitra()
    {
        return $this->belongsToMany(Mitra::class);
    }

    public function getMitraName()
    {
        return $this->mitra->pluck('nama') ?? null;
    }

    /**
     * @method public assignMitra($mitra sting|ing|Model)
     * @param kode_mitra|id|App\Models\Mitra
     */
    public function assignMitra($mitra)
    {
        $mitra = Mitra::findMitra($mitra);
        return $this->mitra()->attach($mitra, [
            'nama_user' => $this->nama,
            'mitra_kode' => $mitra->kode_mitra,
            'created_at' => Carbon::now()
        ]);
    }

    public function dropMitra($mitra = null): Int
    {
        if ($mitra === null) {
            return $this->mitra()->detach();
        } else {
            $mitra = Mitra::findMitra($mitra);
            return $this->mitra()->detach($mitra);
        }
    }

    // public function hasMitra()
    // {
    //     self::whereHas('roles', function($query) {
    //         $query->where('id', 3);
    //     })
    //     ->get();
    // }
}
