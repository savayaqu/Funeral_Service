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
        return $this->belongsTo(Payment::class);
    }
    public function users()
    {
        return $this->belongsTo(User::class);
    }
    public function employees()
    {
        return $this->belongsTo(User::class);
    }
    public function status_orders()
    {
        return $this->belongsTo(Status_Order::class);
    }
}
