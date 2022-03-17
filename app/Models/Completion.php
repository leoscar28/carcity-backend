<?php

namespace App\Models;

use App\Domain\Contracts\CompletionContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Completion extends Model
{
    use HasFactory;
    protected $fillable =   CompletionContract::FILLABLE;
    public function completionList(): HasMany
    {
        return $this->hasMany(CompletionList::class);
    }
}
