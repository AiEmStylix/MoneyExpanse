<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_id',
        'date',
        'amount',
        'payee',
        'description',
        'inflow',
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
        'inflow' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class)->withTrashed();
    }

    public function scopeExpenses($query)
    {
        return $query->where('inflow', false);
    }

    public function scopeIncome($query)
    {
        return $query->where('inflow', true);
    }
}
