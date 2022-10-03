<?php

namespace App\Models;

use App\Domain\Contracts\MainContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class FeedbackRequestMessageImage extends Model
{
    use HasFactory;

    protected $table = 'feedback_request_message_images';

    protected $fillable = [
        MainContract::FEEDBACK_REQUEST_MESSAGE_ID,
        MainContract::TITLE,
        MainContract::PATH
    ];


    protected $hidden = [MainContract::CREATED_AT, MainContract::UPDATED_AT];

    public function getPathAttribute($value): string
    {
        return URL::to('/').'/storage/'.$value;
    }
}
