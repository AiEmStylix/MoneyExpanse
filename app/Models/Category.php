<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_group_id',
        'name',
        'order',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(CategoryGroup::class);
    }
}
