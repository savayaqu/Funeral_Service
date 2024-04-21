<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
        'patronymic',
        'login',
        'password',
        'email',
        'telephone',
        'api_token',
        'role_id',
        'shift_id',
    ];
    public function shifts()
    {
        return $this->belongsTo(Shift::class);
    }
    public function roles()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function hasRoleByCode(array $codes) {
        $userRole = $this->roles()->first();
        return in_array($userRole->code, $codes);
    }

}
