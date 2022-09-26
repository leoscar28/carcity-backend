<?php


namespace App\Services;


use App\Domain\Repositories\FeedbackRequest\FeedbackRequestRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class FeedbackRequestService
{
    protected FeedbackRequestRepositoryInterface $feedbackRequestRepository;

    public function __construct(FeedbackRequestRepositoryInterface $feedbackRequestRepository)
    {
        $this->feedbackRequestRepository = $feedbackRequestRepository;
    }

    public function create($data)
    {
        return $this->feedbackRequestRepository->create($data);
    }

    public function update($id,$data)
    {
        return $this->feedbackRequestRepository->update($id,$data);
    }

    public function pagination($data)
    {
        return $this->feedbackRequestRepository->pagination($data);
    }

    public function all($data): Collection|array
    {
        return $this->feedbackRequestRepository->all($data);
    }

    public function getById($data)
    {
        return $this->feedbackRequestRepository->getById($data);
    }

    public function close($id)
    {
        $this->feedbackRequestRepository->close($id);
    }
}
