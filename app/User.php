<?php

namespace App;

use App\Notifications\NewBkoUser;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {

            // Generates a random password
            $password = $user->generatePassword();
            $user->password = Hash::make($password);


            // Send mail notification to user
            $user->notify(new NewBkoUser($password));

        });
    }

    /**
     * Send the password reset notification.
     *
     * @param  string $token
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function scopeRegular($query)
    {
        return $query->whereNotIn('id', config('app.admin_users'));
    }

    public function generatePassword()
    {
        return str_random(10);
    }
}
