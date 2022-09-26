<?php

namespace App\Models;

use App\Domain\Contracts\FeedbackRequestContract;
use App\Domain\Contracts\MainContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackRequest extends Model
{
    use HasFactory;

    protected $table = FeedbackRequestContract::TABLE;
    protected $fillable =   FeedbackRequestContract::FILLABLE;

    public function messages(){
        return $this->hasMany(FeedbackRequestMessage::class, MainContract::FEEDBACK_REQUEST_ID, MainContract::ID)->with(['image']);
    }

    public function firstMessage(){
        return $this->hasOne(FeedbackRequestMessage::class, MainContract::FEEDBACK_REQUEST_ID, MainContract::ID)->oldest()->with(['image']);
    }

    public function user(){
        return $this->hasOne(User::class, MainContract::ID, MainContract::USER_ID);
    }
}
