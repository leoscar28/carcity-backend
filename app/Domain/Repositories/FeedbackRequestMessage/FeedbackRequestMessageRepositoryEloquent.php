<?php


namespace App\Domain\Repositories\FeedbackRequestMessage;

use App\Domain\Contracts\MainContract;
use App\Models\FeedbackRequestMessage;

class FeedbackRequestMessageRepositoryEloquent implements FeedbackRequestMessageRepositoryInterface
{
    public function getById($id): object|null
    {
        return FeedbackRequestMessage::where(MainContract::ID,$id)->with(['image'])->first();
    }

    public function create($data): ?object
    {
        $feedbackMessage = FeedbackRequestMessage::create($data);
        return $this->getById($feedbackMessage->{MainContract::ID});
    }
}
