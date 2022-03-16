<?php

namespace App\Models;

use App\Domain\Contracts\ApplicationListContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationList extends Model
{
    use HasFactory;
    protected $fillable =   ApplicationListContract::FILLABLE;
}
