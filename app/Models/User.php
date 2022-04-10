<?php

namespace App\Models;

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\UserContract;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use CrudTrait;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable =   UserContract::FILLABLE;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden   =   UserContract::HIDDEN;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts    =   UserContract::CASTS;

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function roles(): BelongsTo
    {
        return $this->belongsTo(Role::class,MainContract::ROLE_ID,MainContract::ID);
    }

    public function positions(): BelongsTo
    {
        return $this->belongsTo(Position::class,MainContract::POSITION_ID,MainContract::ID);
    }
}
