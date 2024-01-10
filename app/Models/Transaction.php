<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = ['customer_id', 'tenant_id', 'total_spent'];
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function vouchers()
    {
        return $this->hasMany(Voucher::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'transaction_details')
            ->withPivot('quantity', 'subtotal');
    }
}
