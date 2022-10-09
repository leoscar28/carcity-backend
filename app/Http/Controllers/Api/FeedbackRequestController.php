<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\FeedbackRequestContract;
use App\Domain\Contracts\MainContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\FeedbackRequest\FeedbackRequestAddMessageRequest;
use App\Http\Requests\FeedbackRequest\FeedbackRequestCreateRequest;
use App\Http\Requests\FeedbackRequest\FeedbackRequestListRequest;
use App\Http\Resources\FeedbackRequest\FeedbackRequestCollection;
use App\Http\Resources\FeedbackRequest\FeedbackRequestResource;
use App\Jobs\FeedbackRequestJob;
use App\Models\FeedbackRequest;
use App\Models\FeedbackRequestMessageImage;
use App\Services\FeedbackRequestMessageService;
use App\Services\FeedbackRequestService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Facades\Image;

class FeedbackRequestController extends Controller
{
    protected FeedbackRequestService $feedbackRequestService;
    protected FeedbackRequestMessageService $feedbackRequestMessageService;
    public function __construct(FeedbackRequestService $feedbackRequestService, FeedbackRequestMessageService $feedbackRequestMessageService)
    {
        $this->feedbackRequestService   =   $feedbackRequestService;
        $this->feedbackRequestMessageService   =   $feedbackRequestMessageService;
    }

    /**
     * @param FeedbackRequestCreateRequest $feedbackRequestListRequest
     * @return FeedbackRequestResource
     */
    public function create(FeedbackRequestCreateRequest $feedbackRequestListRequest)
    {
        $data = $feedbackRequestListRequest->check();

        if (array_key_exists(MainContract::IMAGES, $data)) {
            unset($data[MainContract::IMAGES]);
        }

        $feedbackRequest = $this->feedbackRequestService->create($data);

        $feedbackRequestMessage = $this->feedbackRequestMessageService->create([
            MainContract::USER_ID => $data[MainContract::USER_ID],
            MainContract::TYPE => 'request',
            MainContract::FEEDBACK_REQUEST_ID => $feedbackRequest->{MainContract::ID},
            MainContract::DESCRIPTION => $data[MainContract::DESCRIPTION]
        ]);

        if($feedbackRequestListRequest->hasFile('file')) {
            $allowedExtension = ['jpg','png', 'jpeg', 'bmp', 'docx', 'doc', 'txt', 'pdf', 'xlsx', 'xls'];

            $file = $feedbackRequestListRequest->file('file');


            if (in_array($file->getClientOriginalExtension(), $allowedExtension)) {

                $new_file_name = md5($file->getClientOriginalName().random_int(1, 9999).time()).'.'.$file->getClientOriginalExtension();

                $path = public_path('storage/feedback/');
                if (!file_exists($path)) {
                    mkdir($path, 755, true);
                }

                $file->storeAs(
                    'feedback', $new_file_name, 'public'
                );

                FeedbackRequestMessageImage::create([
                    MainContract::FEEDBACK_REQUEST_MESSAGE_ID => $feedbackRequestMessage->{MainContract::ID},
                    MainContract::TITLE => $file->getClientOriginalName(),
                    MainContract::PATH => 'feedback/'.$new_file_name
                ]);
            }

        }

        $feedbackRequest = $this->feedbackRequestService->getById($feedbackRequest->{MainContract::ID});

        FeedbackRequestJob::dispatch($feedbackRequest);

        return new FeedbackRequestResource($feedbackRequest);
    }


    /**
     * @param FeedbackRequestListRequest $feedbackRequestListRequest
     * @return mixed
     * @throws ValidationException
     */
    public function pagination(FeedbackRequestListRequest $feedbackRequestListRequest)
    {
        return $this->feedbackRequestService->pagination($feedbackRequestListRequest->check());
    }

    /**
     * @param FeedbackRequestListRequest $feedbackRequestListRequest
     * @return FeedbackRequestCollection
     * @throws ValidationException
     */
    public function all(FeedbackRequestListRequest $feedbackRequestListRequest): FeedbackRequestCollection
    {
        return new FeedbackRequestCollection($this->feedbackRequestService->all($feedbackRequestListRequest->check()));
    }

    public function getById($id, Request $request): FeedbackRequestResource|Response
    {
        if ($feedbackRequest = $this->feedbackRequestService->getById($id)) {
            return new FeedbackRequestResource($feedbackRequest);
        }
        return response(['message'  =>  'Сообщение не найдено'],404);
    }


    public function addMessage(FeedbackRequestAddMessageRequest $feedbackRequestAddMessageRequest)
    {
        $data = $feedbackRequestAddMessageRequest->check();

        if (array_key_exists(MainContract::IMAGES, $data)) {
            unset($data[MainContract::IMAGES]);
        }

        $feedbackRequestMessage = $this->feedbackRequestMessageService->create($data);

        $statusData = [MainContract::STATUS => FeedbackRequestContract::STATUS_ANSWER_CLIENT];

        if ($feedbackRequestMessage->{MainContract::TYPE} !== 'request') {
          $statusData = [MainContract::STATUS => FeedbackRequestContract::STATUS_ANSWER];
        }

        $this->feedbackRequestService->update($feedbackRequestMessage->{MainContract::FEEDBACK_REQUEST_ID}, $statusData);

        if($feedbackRequestAddMessageRequest->hasFile('file')) {
            $allowedExtension = ['jpg','png', 'jpeg', 'bmp', 'docx', 'doc', 'txt', 'pdf', 'xlsx', 'xls'];

            $file = $feedbackRequestAddMessageRequest->file('file');

            if (in_array($file->getClientOriginalExtension(), $allowedExtension)) {

                $new_file_name = md5($file->getClientOriginalName().random_int(1, 9999).time()).'.'.$file->getClientOriginalExtension();

                $path = public_path('storage/feedback/');
                if (!file_exists($path)) {
                    mkdir($path, 755, true);
                }

                $file->storeAs(
                    'feedback', $new_file_name, 'public'
                );

                FeedbackRequestMessageImage::create([
                    MainContract::FEEDBACK_REQUEST_MESSAGE_ID => $feedbackRequestMessage->{MainContract::ID},
                    MainContract::TITLE => $file->getClientOriginalName(),
                    MainContract::PATH => 'feedback/'.$new_file_name
                ]);
            }
        }

        $feedbackRequest = $this->feedbackRequestService->getById($feedbackRequestMessage->{MainContract::FEEDBACK_REQUEST_ID});

        FeedbackRequestJob::dispatch($feedbackRequest);

        return new FeedbackRequestResource($feedbackRequest);
    }

    public function close($id)
    {
        $this->feedbackRequestService->close($id);

        $feedbackRequest = $this->feedbackRequestService->getById($id);

        FeedbackRequestJob::dispatch($feedbackRequest);
    }

    public function count($type)
    {
        switch ($type){
            case 'new':
                $count = FeedbackRequest::whereIn(MainContract::STATUS, [FeedbackRequestContract::STATUS_NEW, FeedbackRequestContract::STATUS_ANSWER_CLIENT])->count();
                break;
            case 'answered':
                $count = FeedbackRequest::whereIn(MainContract::STATUS, [FeedbackRequestContract::STATUS_ANSWER])->count();
                break;
            case 'closed':
                $count = FeedbackRequest::whereIn(MainContract::STATUS, [FeedbackRequestContract::STATUS_CLOSE])->count();
                break;
            default:
                $count = FeedbackRequest::count();
        }

        return $count;
    }
}
