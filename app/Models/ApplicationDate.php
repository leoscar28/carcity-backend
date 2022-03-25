<?php

namespace App\Models;

use App\Domain\Contracts\ApplicationDateContract;
use App\Domain\Contracts\MainContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ApplicationDate extends Model
{
    use HasFactory;
    protected $fillable =   ApplicationDateContract::FILLABLE;

    public function application(): HasMany
    {
        return $this->hasMany(Application::class,MainContract::RID,MainContract::RID);
    }

    public function applicationStatus(): BelongsTo
    {
        return $this->belongsTo(ApplicationStatus::class,MainContract::UPLOAD_STATUS_ID,MainContract::ID);
    }

}
