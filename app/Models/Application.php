<?php

namespace App\Models;

use App\Domain\Contracts\ApplicationContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;
    protected $fillable =   ApplicationContract::FILLABLE;
}
