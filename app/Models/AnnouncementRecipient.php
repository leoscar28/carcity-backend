<?php

namespace App\Models;

use App\Domain\Contracts\AnnouncementRecipientContract;
use App\Domain\Contracts\MainContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnouncementRecipient extends Model
{
    use HasFactory;

    protected $table = AnnouncementRecipientContract::TABLE;
    protected $fillable =   AnnouncementRecipientContract::FILLABLE;

    public function announcement(){
        return $this->hasOne(Announcement::class, MainContract::ID, MainContract::ANNOUNCEMENT_ID);
    }

    public function file(){
        return $this->hasOne(AnnouncementFile::class, MainContract::ANNOUNCEMENT_ID, MainContract::ANNOUNCEMENT_ID);
    }

    public function user(){
        return $this->hasOne(User::class, MainContract::ID, MainContract::USER_ID);
    }
}
