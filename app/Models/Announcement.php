<?php

namespace App\Models;

use App\Domain\Contracts\AnnouncementContract;
use App\Domain\Contracts\MainContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $table = AnnouncementContract::TABLE;
    protected $fillable =   AnnouncementContract::FILLABLE;

    public function recipients(){
        return $this->hasMany(AnnouncementRecipient::class);
    }

    public function file(){
        return $this->hasOne(AnnouncementFile::class, MainContract::ANNOUNCEMENT_ID, MainContract::ID);
    }
}
