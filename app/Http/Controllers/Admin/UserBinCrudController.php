<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Contracts\MainContract;
use App\Http\Requests\UserBinRequest;
use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class UserBinCrudController extends CrudController
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
        CRUD::setModel(\App\Models\UserBin::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user-bin');
        CRUD::setEntityNameStrings('ЭЦП бин', 'ЭЦП бины');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation(): void
    {
        CRUD::column(MainContract::IIN)->label('БИН/ИИН пользователя');
        CRUD::column(MainContract::BIN)->label('БИН/ИИН эцп');
        CRUD::column(MainContract::STATUS)->type('select_from_array')
            ->label('Статус')->options([
                0   =>  'Отключен',
                1   =>  'Включен'
            ]);
    }
    protected function setupShowOperation(): void
    {
        CRUD::column(MainContract::IIN)->label('БИН/ИИН пользователя')->type('select2_from_ajax');
        CRUD::column(MainContract::BIN)->label('БИН/ИИН эцп');
        CRUD::column(MainContract::STATUS)->type('select_from_array')
            ->label('Статус')->options([
                0   =>  'Отключен',
                1   =>  'Включен'
            ]);
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(UserBinRequest::class);
        CRUD::field(MainContract::IIN)->label('БИН/ИИН пользователя');
        CRUD::field(MainContract::BIN)->label('БИН/ИИН эцп');
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
