<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Contracts\MainContract;
use App\Http\Requests\UploadStatusRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class UploadStatusCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\UploadStatus::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/upload-status');
        CRUD::setEntityNameStrings('Статус выгрузки', 'Статусы');
    }

    protected function setupListOperation()
    {
        CRUD::column(MainContract::ID)->label('ID');
        CRUD::column(MainContract::TITLE)->label('Название');
        CRUD::column(MainContract::STATUS)->type('select_from_array')
            ->label('Статус')->options([
                0   =>  'Отключен',
                1   =>  'Включен'
            ]);
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(UploadStatusRequest::class);
        CRUD::field(MainContract::TITLE)->label('Название');
        CRUD::field(MainContract::STATUS)->type('select_from_array')
            ->label('Статус')->options([
                0   =>  'Отключен',
                1   =>  'Включен'
            ])->default(1);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
