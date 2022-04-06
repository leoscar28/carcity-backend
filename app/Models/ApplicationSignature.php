<?php

namespace App\Models;

use App\Domain\Contracts\ApplicationSignatureContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationSignature extends Model
{
    use HasFactory;
    protected $fillable =   ApplicationSignatureContract::FILLABLE;
}
