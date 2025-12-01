<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected static function booted(): void
    {
        static::creating(function ($category) {
            $maxOrder = Category::where('category_group_id', $category->category_group_id)
                ->max('order');

            $category->order = ($maxOrder ?? -1) + 1;
        });
    }

    protected $fillable = [
        'category_group_id',
        'name',
        'order',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(CategoryGroup::class, 'category_group_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function budgetAssignments(): HasMany
    {
        return $this->hasMany(BudgetAssignment::class);
    }
}
