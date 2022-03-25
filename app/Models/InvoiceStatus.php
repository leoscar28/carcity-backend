<?php

namespace App\Models;

use App\Domain\Contracts\InvoiceStatusContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceStatus extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    protected $fillable =   InvoiceStatusContract::FILLABLE;
}
