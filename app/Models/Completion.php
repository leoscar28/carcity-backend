<?php

namespace App\Models;

use App\Domain\Contracts\CompletionContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Completion extends Model
{
    use HasFactory;
    protected $fillable =   CompletionContract::FILLABLE;
}
