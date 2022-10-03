<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\AnnouncementContract;
use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\UserContract;
use App\Http\Controllers\Controller;

use App\Http\Requests\Announcement\AnnouncementCreateRequest;
use App\Http\Requests\Announcement\AnnouncementListRequest;
use App\Http\Resources\AnnouncementRecipient\AnnouncementRecipientCollection;
use App\Http\Resources\Announcement\AnnouncementCollection;
use App\Http\Resources\AnnouncementRecipient\AnnouncementRecipientResource;
use App\Http\Resources\Announcement\AnnouncementResource;
use App\Http\Resources\User\UserCollection;
use App\Models\AnnouncementFile;
use App\Models\User;
use App\Services\AnnouncementRecipientService;
use App\Services\AnnouncementService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Facades\Image;

class AnnouncementController extends Controller
{
    protected AnnouncementService $announcementService;
    protected AnnouncementRecipientService $announcementRecipientService;
    public function __construct(AnnouncementService $announcementService, AnnouncementRecipientService $announcementRecipientService)
    {
        $this->announcementService   =   $announcementService;
        $this->announcementRecipientService   =   $announcementRecipientService;
    }

    /**
     * @param AnnouncementCreateRequest $announcementCreateRequest
//     * @return AnnouncementResource
     */
    public function create(AnnouncementCreateRequest $announcementCreateRequest)
    {
        $data = $announcementCreateRequest->check();

        if (array_key_exists(MainContract::FILE, $data)) {
            unset($data[MainContract::FILE]);
        }
        
        if ($data[MainContract::IDS]) {
            $data[MainContract::IDS] = explode(',', $data[MainContract::IDS]);
        }        

        if (!count($data[MainContract::IDS])) {
            $data[MainContract::IDS] = User::where(MainContract::STATUS,1)->where(MainContract::ROLE_ID,1)->pluck('id')->toArray();
        }
        
        return $data[MainContract::IDS];

        $announcement = $this->announcementService->create($data);

        foreach ($data[MainContract::IDS] as $user_id) {
            $this->announcementRecipientService->create([
                MainContract::USER_ID => $user_id,
                MainContract::ANNOUNCEMENT_ID => $announcement->{MainContract::ID},
                MainContract::VIEW => 0
            ]);
        }

        if($announcementCreateRequest->hasFile('file')) {
            $allowedExtension = ['jpg','png', 'jpeg', 'bmp', 'docx', 'doc', 'txt', 'pdf', 'xlsx', 'xls'];

            $file = $announcementCreateRequest->file('file');

            if (in_array($file->getClientOriginalExtension(), $allowedExtension)) {

                $new_file_name = md5($file->getClientOriginalName().random_int(1, 9999).time()).'.'.$file->getClientOriginalExtension();

                $path = public_path('storage/announcements/');

                if (!file_exists($path)) {
                    mkdir($path, 755, true);
                }

                $file->storeAs(
                    'announcements', $new_file_name, 'public'
                );

                AnnouncementFile::create([
                    MainContract::ANNOUNCEMENT_ID => $announcement->{MainContract::ID},
                    MainContract::TITLE => $file->getClientOriginalName(),
                    MainContract::PATH => 'announcements/'.$new_file_name
                ]);
            }
        }

        $announcement = $this->announcementService->getById($announcement->{MainContract::ID});

        return new AnnouncementResource($announcement);
    }


    /**
     * @param AnnouncementListRequest $announcementRecipientListRequest
     * @return mixed
     * @throws ValidationException
     */
    public function pagination(AnnouncementListRequest $announcementRecipientListRequest)
    {
        return $this->announcementRecipientService->pagination($announcementRecipientListRequest->check());
    }

    /**
     * @param AnnouncementListRequest $announcementRecipientListRequest
     * @return AnnouncementRecipientCollection
     * @throws ValidationException
     */
    public function all(AnnouncementListRequest $announcementRecipientListRequest): AnnouncementRecipientCollection
    {
        return new AnnouncementRecipientCollection($this->announcementRecipientService->all($announcementRecipientListRequest->check()));
    }

    public function getById($id, Request $request): AnnouncementRecipientResource|Response
    {
        if ($announcementRecipient = $this->announcementRecipientService->getById($id)) {
            return new AnnouncementRecipientResource($announcementRecipient);
        }
        return response(['message'  =>  'Сообщение не найдено'],404);
    }


    public function setView($id)
    {
        return new AnnouncementRecipientResource($this->announcementRecipientService->setView($id));
    }

    public function getNotViewed(Request $request)
    {
        $model = $this->announcementRecipientService->getNotViewed($request);
        return $model ? new AnnouncementRecipientResource($model) : null;
    }

    public function activeCustomers()
    {
        return ['data' => User::where(MainContract::STATUS,1)->where(MainContract::ROLE_ID,1)->select('id', DB::raw("CONCAT(name,' ',surname) as text"))->get()];
    }
}
