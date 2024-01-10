<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['tenant_id', 'name', 'price', 'description'];

    public function transactions()
    {
        return $this->belongsToMany(Transaction::class, 'transaction_details')
            ->withPivot('quantity', 'subtotal');
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
