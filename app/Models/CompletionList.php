<?php

namespace App\Models;

use App\Domain\Contracts\CompletionListContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CompletionList extends Model
{
    use HasFactory;
    protected $fillable =   CompletionListContract::FILLABLE;
    public function setDateAttribute($value): string
    {
        return date('Y-m-d',strtotime($value));
    }
}
