<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id',
        'username',
        'name',
        'alamat',
        'tempatLahir',
        'tanggalLahir',
        'pendidikanTerakhir',
        'pekerjaan',
        'penghasilan',
        'noHp',
        'role',
        'email',
        'bio',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
