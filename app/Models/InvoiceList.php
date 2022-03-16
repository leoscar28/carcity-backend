<?php

namespace App\Models;

use App\Domain\Contracts\InvoiceListContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceList extends Model
{
    use HasFactory;
    protected $fillable =   InvoiceListContract::FILLABLE;
}
