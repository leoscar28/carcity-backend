<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Contracts\MainContract;
use App\Http\Requests\PrivacyPolicyRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class PrivacyPolicyCrudController extends CrudController
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
        CRUD::setModel(\App\Models\PrivacyPolicy::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/privacy-policy');
        CRUD::setEntityNameStrings('Политика конфиденциальности', 'Политика конфиденциальности');
    }

    protected function setupShowOperation(): void
    {
        CRUD::column(MainContract::ID)->label('ID')->type('text');
        CRUD::column(MainContract::BODY)->label('Контент')->type('text');
        CRUD::column(MainContract::BODY_KZ)->label('Контент (Каз)')->type('textarea');
        CRUD::column(MainContract::STATUS)->type('select_from_array')
            ->label('Статус')->options([
                0   =>  'Отключен',
                1   =>  'Включен'
            ]);
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation(): void
    {
        CRUD::column(MainContract::ID)->label('ID')->type('text');
        CRUD::column(MainContract::BODY)->label('Контент')->type('text');
        CRUD::column(MainContract::BODY_KZ)->label('Контент (Каз)')->type('textarea');
        CRUD::column(MainContract::STATUS)->type('select_from_array')
            ->label('Статус')->options([
                0   =>  'Отключен',
                1   =>  'Включен'
            ]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(PrivacyPolicyRequest::class);

        CRUD::field(MainContract::BODY)->label('Контент')->type('textarea');
        CRUD::field(MainContract::BODY_KZ)->label('Контент (Каз)')->type('textarea');
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
