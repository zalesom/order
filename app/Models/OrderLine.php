<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class OrderLine extends Model
{
    use HasFactory;

    protected $attributes = [
        'quantity' => 1
    ];

    protected $casts = [
        'total' => 'decimal:2'
    ];

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function relatedProducts(): BelongsToMany
    {
        return $this->belongsToMany(RelatedProduct::class)
            ->withPivot('price', 'title')
            ->withTimestamps();
    }

    protected static function booted()
    {
        static::creating(function ($orderLine) {
            $orderLine->title = $orderLine->product->title;
        });
    }

    public function total()
    {
        return ($this->product->price + $this->relatedProducts()->sum('related_products.price')) * $this->quantity;
    }


    public function recalculate()
    {
        $this->attributes['total'] = $this->total();
        $this->save();
    }
}
