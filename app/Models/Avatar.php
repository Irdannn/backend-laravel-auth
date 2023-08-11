<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Avatar extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = false;
    use HasFactory;
    protected $fillable = ['user_id', 'avatar'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function userProfile()
    {
        return $this->hasMany(Profile::class, 'avatar_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

}
