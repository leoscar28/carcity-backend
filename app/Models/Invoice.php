<?php

namespace App\Models;

use App\Domain\Contracts\InvoiceContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable =   InvoiceContract::FILLABLE;
}
