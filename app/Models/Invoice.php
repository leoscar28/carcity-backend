<?php

namespace App\Models;

use App\Domain\Contracts\InvoiceContract;
use App\Domain\Contracts\MainContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable =   InvoiceContract::FILLABLE;

    public function setDateAttribute($value): string
    {
        return date('Y-m-d',strtotime($value));
    }

    public function invoiceStatus(): BelongsTo
    {
        return $this->belongsTo(InvoiceStatus::class,MainContract::UPLOAD_STATUS_ID,MainContract::ID);
    }

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class,MainContract::CUSTOMER_ID,MainContract::BIN);
    }

}
