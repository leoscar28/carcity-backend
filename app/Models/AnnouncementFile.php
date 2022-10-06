<?php

namespace App\Models;

use App\Domain\Contracts\AnnouncementFileContract;
use App\Domain\Contracts\MainContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class AnnouncementFile extends Model
{
    use HasFactory;

    protected $table = AnnouncementFileContract::TABLE;

    protected $fillable = AnnouncementFileContract::FILLABLE;

    protected $hidden = [MainContract::CREATED_AT, MainContract::UPDATED_AT];

    public function getPathAttribute($value): string
    {
        return URL::to('/').'/storage/'.$value;
    }
}
