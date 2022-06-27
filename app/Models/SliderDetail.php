<?php

namespace App\Models;

use App\Domain\Contracts\SliderDetailContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SliderDetail extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    protected $fillable =   SliderDetailContract::FILLABLE;
}
