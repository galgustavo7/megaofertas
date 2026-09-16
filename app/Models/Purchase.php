<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    public const STATUSES = [
        'nuevo' => 'Nuevo',
        'pendiente' => 'Pendiente',
        'aprobado' => 'Aprobado',
        'reversado' => 'Reversado',
    ];

    protected $fillable = [
        'product_id', 'customer_name', 'customer_email', 'amount',
        'commission', 'status', 'purchase_date',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'commission' => 'decimal:2',
            'purchase_date' => 'date',
        ];
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeByStatus(Builder $query, ?string $status): Builder
    {
        if ($status && isset(self::STATUSES[$status])) {
            return $query->where('status', $status);
        }

        return $query;
    }

    public function scopeInMonth(Builder $query, ?string $month): Builder
    {
        if ($month && preg_match('/^\d{4}-\d{2}$/', $month)) {
            return $query->whereRaw("strftime('%Y-%m', purchase_date) = ?", [$month]);
        }

        return $query;
    }

    public function statusLabel(): string
    {
        return self::STATUSES[$this->status] ?? ucfirst($this->status);
    }
}
