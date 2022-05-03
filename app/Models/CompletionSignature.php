<?php

namespace App\Models;

use App\Domain\Contracts\CompletionSignatureContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompletionSignature extends Model
{
    use HasFactory;
    protected $fillable =   CompletionSignatureContract::FILLABLE;
}
