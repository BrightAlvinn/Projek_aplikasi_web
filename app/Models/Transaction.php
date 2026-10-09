<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'type',
        'amount',
        'transaction_date',
        'description',
        'notes',
        'receipt_path',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'transaction_date' => 'date',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    protected function formattedAmount(): Attribute
    {
        return Attribute::make(
            get: fn () => 'Rp ' . number_format((float) $this->amount, 0, ',', '.'),
        );
    }

    public function scopeIncome(Builder $query): Builder
    {
        return $query->where('type', 'income');
    }

    public function scopeExpense(Builder $query): Builder
    {
        return $query->where('type', 'expense');
    }
}