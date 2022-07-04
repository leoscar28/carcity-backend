<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Contracts\MainContract;
use App\Http\Requests\InfrastructureRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class InfrastructureCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup(): void
    {
        CRUD::setModel(\App\Models\Infrastructure::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/infrastructure');
        CRUD::setEntityNameStrings('Инфраструкура', 'Инфраструкура');
    }

    protected function setupShowOperation(): void
    {
        CRUD::column(MainContract::TITLE)->label('Заголовок');
        CRUD::column(MainContract::TITLE_KZ)->label('Заголовок (Каз)');
        CRUD::column(MainContract::DESCRIPTION)->label('Описание');
        CRUD::column(MainContract::DESCRIPTION_KZ)->label('Описание (Каз)');
        CRUD::column(MainContract::STATUS)->type('select_from_array')
            ->label('Статус')->options([
                0   =>  'Отключен',
                1   =>  'Включен'
            ]);
    }

    protected function setupListOperation()
    {
        CRUD::column(MainContract::TITLE)->label('Заголовок');
        CRUD::column(MainContract::TITLE_KZ)->label('Заголовок (Каз)');
        CRUD::column(MainContract::DESCRIPTION)->label('Описание');
        CRUD::column(MainContract::DESCRIPTION_KZ)->label('Описание (Каз)');
        CRUD::column(MainContract::STATUS)->type('select_from_array')
            ->label('Статус')->options([
                0   =>  'Отключен',
                1   =>  'Включен'
            ]);
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(InfrastructureRequest::class);

        CRUD::field(MainContract::TITLE)->label('Заголовок');
        CRUD::field(MainContract::TITLE_KZ)->label('Заголовок (Каз)');
        CRUD::field(MainContract::DESCRIPTION)->label('Описание');
        CRUD::field(MainContract::DESCRIPTION_KZ)->label('Описание (Каз)');
        CRUD::field(MainContract::STATUS)->type('select_from_array')
            ->label('Статус')->options([
                0   =>  'Отключен',
                1   =>  'Включен'
            ])->default(1);
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation(): void
    {
        $this->setupCreateOperation();
    }
}
