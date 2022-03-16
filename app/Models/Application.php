<?php

namespace App\Models;

use App\Domain\Contracts\ApplicationContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Application extends Model
{
    use HasFactory;
    protected $fillable =   ApplicationContract::FILLABLE;

    public function applicationList(): HasMany
    {
        return $this->hasMany(ApplicationList::class);
    }

}
