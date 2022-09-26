<?php

namespace App\Models;

use App\Domain\Contracts\FeedbackRequestMessageContract;
use App\Domain\Contracts\MainContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackRequestMessage extends Model
{
    use HasFactory;

    protected $table = FeedbackRequestMessageContract::TABLE;
    protected $fillable =   FeedbackRequestMessageContract::FILLABLE;

    public function user(){
        return $this->hasOne(User::class, MainContract::ID, MainContract::USER_ID);
    }

    public function image(){
        return $this->hasOne(FeedbackRequestMessageImage::class, MainContract::FEEDBACK_REQUEST_MESSAGE_ID, MainContract::ID);
    }
}
