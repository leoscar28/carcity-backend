<?php

namespace App\Models;

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\RoomContract;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Room extends Model
{
    use CrudTrait;
    use HasFactory;
    protected $fillable =   RoomContract::FILLABLE;

    public function tier(): BelongsTo
    {
        return $this->belongsTo(Tier::class,MainContract::TIER_ID,MainContract::ID);
    }

    public function roomType(): BelongsTo
    {
        return $this->belongsTo(RoomType::class,MainContract::ROOM_TYPE_ID,MainContract::ID)
            ->where(MainContract::STATUS,1);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,MainContract::USER_ID,MainContract::ID)
            ->where(MainContract::STATUS,1);
    }

}
