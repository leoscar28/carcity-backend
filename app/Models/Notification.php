<?php

namespace App\Models;

use App\Domain\Contracts\NotificationContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable =   NotificationContract::FILLABLE;
}
