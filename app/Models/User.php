<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
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
        $this->belongsTo(Shift::class);
    }
    public function roles()
    {
        $this->belongsTo(Role::class);
    }
    public function carts()
    {
        $this->hasMany(Cart::class);
    }
    public function orders()
    {
        $this->hasMany(Order::class);
    }
    public function reviews()
    {
        $this->hasMany(Review::class);
    }

    public function hasRole(array $role)
    {
        return in_array($this->role->code,$role);
    }
}
