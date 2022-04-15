<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'total',
        'payment_status',
        'url',
        'session_id',
        'client_id',
    ];

    public function client():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products():BelongsToMany
    {
        //return $this->belongsToMany(Product::class)->whitPivot('quantity','subtotal','price');
        return $this->belongsToMany(Product::class);
    }
}
