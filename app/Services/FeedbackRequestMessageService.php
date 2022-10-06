<?php


namespace App\Services;


use App\Domain\Repositories\FeedbackRequestMessage\FeedbackRequestMessageRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class FeedbackRequestMessageService
{
    protected FeedbackRequestMessageRepositoryInterface $feedbackRequestRepository;

    public function __construct(FeedbackRequestMessageRepositoryInterface $feedbackRequestRepository)
    {
        $this->feedbackRequestRepository = $feedbackRequestRepository;
    }

    public function create($data)
    {
        return $this->feedbackRequestRepository->create($data);
    }

}
