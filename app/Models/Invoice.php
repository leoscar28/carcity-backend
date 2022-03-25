<?php

namespace App\Models;

use App\Domain\Contracts\InvoiceContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable =   InvoiceContract::FILLABLE;
    public function setDateAttribute($value): string
    {
        return date('Y-m-d',strtotime($value));
    }
}
