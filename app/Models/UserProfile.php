<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UserProfile extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = false; // Set to false to indicate that the primary key is not auto-incrementing
    protected $fillable = [
        'user_id',
        'avatar_id',
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
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function avatar()
    {
        return $this->belongsTo(Avatar::class, 'avatar_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }
}
