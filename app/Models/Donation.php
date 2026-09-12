<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Donation extends Model
{
    protected $fillable = [
        'donor_name',
        'project_id',
        'donor_email',
        'donor_phone',
        'country',
        'amount',
        'frequency',
        'payment_method',
        'transaction_id',
        'status',
        'message',
        'is_anonymous',
        'dedication_name',
        'dedication_type',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'is_anonymous' => 'boolean',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
