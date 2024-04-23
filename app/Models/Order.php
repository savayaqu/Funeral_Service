<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['date_order', 'payment_id', 'user_id', 'employee_id', 'status_order_id'];
    public function compounds()
    {
        return $this->hasMany(Compound::class);
    }
    public function payments()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function employees()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
    public function status_orders()
    {
        return $this->belongsTo(StatusOrder::class, 'status_order_id');
    }
}
