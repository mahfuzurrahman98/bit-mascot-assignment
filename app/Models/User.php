<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name', 'last_name',
        'email', 'phone',
        'address', 'dob',
        'id_verification_file',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Returns the user's full name.
     *
     * @return string
     */
    public function getNameAttribute(): string
    {
        // Constructs the user's full name from first name and last name
        $name = $this->first_name;
        if ($this->last_name) {
            $name .= ' ' . $this->last_name;
        }
        return $name;
    }

    /**
     * Returns the url of the uploaded ID verification file.
     *
     * @return string
     */
    public function getIdVerificationFileUrlAttribute(): string
    {
        // returns the url of the uploaded ID verification file
        return asset('storage/' . $this->id_verification_file);
    }
}
