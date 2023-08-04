<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Str;
use App\Traits\UUID;

class User extends Authenticatable implements JWTSubject
{
    protected $primaryKey = 'id';
    public $incrementing = false; // Set to false to indicate that the primary key is not auto-incrementing

    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'name',
        'role',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
        'uuid'            => $this->uuid,
        'username'        => $this->username,
        'name'            => $this->name,
        'email'           => $this->email,
        'role'            => $this->role];
    }

    // Define the relationship with the UserProfile model
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    // Method to create a user profile when a user is registered
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });

        self::created(function ($user) {
            $user->profile()->create([
                'username' => $user->username,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role
            ]);
        });
    }
}
