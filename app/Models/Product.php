<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $casts = [
        'price' => 'decimal:2'
    ];

    public function relatedProducts(): BelongsToMany
    {
        return $this->belongsToMany(RelatedProduct::class);
    }
}
