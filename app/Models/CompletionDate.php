<?php

namespace App\Models;

use App\Domain\Contracts\CompletionDateContract;
use App\Domain\Contracts\MainContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CompletionDate extends Model
{
    use HasFactory;
    protected $fillable =   CompletionDateContract::FILLABLE;

    public function completion(): HasMany
    {
        return $this->hasMany(Completion::class,MainContract::RID,MainContract::RID)->where(MainContract::STATUS,1);
    }

    public function completionStatus(): BelongsTo
    {
        return $this->belongsTo(CompletionStatus::class,MainContract::UPLOAD_STATUS_ID,MainContract::ID);
    }

}
