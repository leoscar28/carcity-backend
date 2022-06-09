<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Contracts\MainContract;
use App\Http\Requests\RoomRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class RoomCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Room::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/room');
        CRUD::setEntityNameStrings('Помещение', 'Помещении');
    }

    protected function setupShowOperation()
    {
        CRUD::column(MainContract::ID)->label('ID');
        CRUD::column(MainContract::TIER_ID)->type('select')->label('Ярус')
            ->entity('tier')->model('App\Models\Tier')->attribute(MainContract::TITLE);
        CRUD::column(MainContract::ROOM_TYPE_ID)->type('select')->label('Тип помещения')
            ->entity('roomType')->model('App\Models\RoomType')->attribute(MainContract::TITLE);
        CRUD::column(MainContract::USER_ID)->type('select')->label('Арендатор')
            ->entity('user')->model('App\Models\User')->attribute(MainContract::COMPANY);
        CRUD::column(MainContract::TITLE)->label('Название помещении');
        CRUD::column(MainContract::STATUS)->type('select_from_array')
            ->label('Статус')->options([
                0   =>  'Отключен',
                1   =>  'Включен',
                2   =>  'Забронирован'
            ]);
    }

    protected function setupListOperation()
    {
        CRUD::column(MainContract::ID)->label('ID');
        CRUD::column(MainContract::TIER_ID)->type('select')->label('Ярус')
            ->entity('tier')->model('App\Models\Tier')->attribute(MainContract::TITLE);
        CRUD::column(MainContract::ROOM_TYPE_ID)->type('select')->label('Тип помещения')
            ->entity('roomType')->model('App\Models\RoomType')->attribute(MainContract::TITLE);
        CRUD::column(MainContract::USER_ID)->type('select')->label('Арендатор')
            ->entity('user')->model('App\Models\User')->attribute(MainContract::COMPANY);
        CRUD::column(MainContract::TITLE)->label('Название помещении');
        CRUD::column(MainContract::STATUS)->type('select_from_array')
            ->label('Статус')->options([
                0   =>  'Отключен',
                1   =>  'Включен',
                2   =>  'Забронирован'
            ]);
    }

    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(RoomRequest::class);

        $this->crud->addFields([
            [
                'name'  => MainContract::TIER_ID,
                'label' => 'Ярус',
                'type'  => 'select',
                'entity'    => 'tier',
                'model'     => "App\Models\Tier",
                'attribute' => MainContract::TITLE,
            ],
            [
                'name'  => MainContract::ROOM_TYPE_ID,
                'label' => 'Тип помещения',
                'type'  => 'select',
                'entity'    => 'roomType',
                'model'     => "App\Models\RoomType",
                'attribute' => MainContract::TITLE,
            ],
            [
                'name'  => MainContract::USER_ID,
                'label' => 'Арендатор (не обязательно)',
                'type'  => 'select',
                'entity'    => 'user',
                'model'     => "App\Models\User",
                'attribute' => MainContract::COMPANY,
                'options'   => (function ($query) {
                    return $query->orderBy(MainContract::COMPANY, 'ASC')->get();
                }),
            ]
        ]);
        CRUD::field(MainContract::TITLE)->label('Название помещении');
        CRUD::field(MainContract::STATUS)->type('select_from_array')
            ->label('Статус')
            ->options([
                0   =>  'Отключен',
                1   =>  'Включен',
                2   =>  'Забронирован'
            ])->default(1);
    }

    protected function setupUpdateOperation(): void
    {
        $this->setupCreateOperation();
    }
}
