<?php

namespace App\Models;

use App\Domain\Contracts\InvoiceDateContract;
use App\Domain\Contracts\MainContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InvoiceDate extends Model
{
    use HasFactory;
    protected $fillable =   InvoiceDateContract::FILLABLE;

    public function invoice(): HasMany
    {
        return $this->hasMany(Invoice::class,MainContract::RID,MainContract::RID)->where(MainContract::STATUS,1);
    }

    public function invoiceStatus(): BelongsTo
    {
        return $this->belongsTo(InvoiceStatus::class,MainContract::UPLOAD_STATUS_ID,MainContract::ID);
    }
}
