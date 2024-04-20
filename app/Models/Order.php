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
        $this->hasMany(Compound::class);
    }
    public function payments()
    {
        $this->belongsTo(Payment::class);
    }
    public function users()
    {
        $this->belongsTo(User::class);
    }
    public function employees()
    {
        $this->belongsTo(User::class);
    }
    public function status_orders()
    {
        $this->belongsTo(Status_Order::class);
    }
}
