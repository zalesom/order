<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RelatedProduct extends Model
{
    use HasFactory;

    public function orderLines(): BelongsToMany
    {
        return $this->belongsToMany(OrderLine::class);
    }
}
