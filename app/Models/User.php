<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

class User extends Model implements Authenticatable
{
    use HasFactory;
    use AuthenticatableTrait;

    protected $table = 'users';
    protected $fillable = [
        'email',
        'nama',
        'password',
        'id_level',
        'profile_picture',
    ];

    public function level()
    {
        return $this->belongsTo(UserLevel::class, 'id_level');
    }

    public function hasRole($role)
    {
        return $this->id_level == $role; // Sesuaikan dengan atribut level yang sesuai pada model User Anda
    }
}
