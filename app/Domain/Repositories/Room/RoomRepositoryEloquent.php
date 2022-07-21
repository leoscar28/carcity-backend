<?php

namespace App\Domain\Repositories\Room;

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\UserBannerContract;
use App\Models\DictionaryBrand;
use App\Models\DictionaryService;
use App\Models\DictionarySparePart;
use App\Models\Room;
use App\Models\UserBanner;
use Illuminate\Database\Eloquent\Collection;

class RoomRepositoryEloquent implements RoomRepositoryInterface
{
    public function getByUserId($userId): Collection|array
    {
        return Room::with('RoomType','tier')
            ->where(MainContract::USER_ID,$userId)
            ->get();
    }

    public function get()
    {
        return Room::with('RoomType','tier')
            ->where(MainContract::STATUS,'!=',0)
            ->get();
    }

    public function getUserInfo($roomId): array
    {
        $room = Room::with('user', 'user.sparePart', 'user.brand', 'user.service')->where(MainContract::ID,$roomId)->first();

        if ($room) {
            $info = [
              'company' => $room->user->company,
              'phone' => $room->user->phone,
              'spare_parts' => [],
              'brands' => [],
              'services' => []
            ];

            if ($room->user->sparePart) {
                $info['spare_parts'][$room->user->spare_part_id] = $room->user->sparePart;
            }
            if ($room->user->brand) {
                $info['spare_parts'][$room->user->brand_id] = $room->user->brand;
            }
            if ($room->user->service) {
                $info['spare_parts'][$room->user->service_id] = $room->user->service;
            }

            $banners = UserBanner::where(MainContract::ROOM_ID, $roomId)->where(MainContract::USER_ID, $room->user_id)->where(MainContract::STATUS, UserBannerContract::STATUS_PUBLISHED)->get();

            if ($banners) {
                foreach ($banners as $banner) {
                    if ($banner->type === 1) {
                        $spareParts = DictionarySparePart::whereIn(MainContract::ID,$banner->category_id)->select(['id', 'name'])->get()->toArray();
                        $brands = DictionaryBrand::whereIn(MainContract::ID,$banner->brand_id)->select(['id', 'name'])->get()->toArray();
                        if (count($spareParts)) {
                            foreach ($spareParts as $sp) {
                                $info['spare_parts'][$sp['id']] = $sp;
                            }
                        }
                        if (count($brands)) {
                            foreach ($brands as $brand) {
                                $info['brands'][$brand['id']] = $brand;
                            }
                        }
                    } else {
                        $services = DictionaryService::whereIn(MainContract::ID,$banner->service_id)->select(['id', 'name'])->get()->keyBy(MainContract::ID)->toArray();
                        if (count($services)) {
                            foreach ($services as $sp) {
                                $info['services'][$sp['id']] = $sp;
                            }
                        }
                    }
                }
                $info['spare_parts'] = array_values($info['spare_parts']);
                $info['brands'] = array_values($info['brands']);
                $info['services'] = array_values($info['services']);
            }

            return $info;
        }

        return [];
    }

}
