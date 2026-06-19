<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QrPayment extends Model
{
    use HasFactory;

    protected $table = 'qr_payments';

    protected $fillable = [
        'user_id',
        'monto',
        'plan',
        'comprobante_path',
        'status',
        'mensaje_admin',
    ];

    /**
     * Get the user that owns the payment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
