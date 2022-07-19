<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Contracts\MainContract;
use App\Http\Requests\AwardsRequest;
use App\Models\Awards;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class AwardsCrudController extends CrudController
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
        CRUD::setModel(Awards::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/awards');
        CRUD::setEntityNameStrings('Награду', 'Награды');
    }

    protected function setupShowOperation(): void
    {
        CRUD::column(MainContract::TITLE)->label('Заголовок');
        CRUD::column(MainContract::TITLE)->label('Заголовок (Каз)');
        CRUD::column(MainContract::IMG)->label('картинка');
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
        CRUD::column(MainContract::TITLE)->label('Заголовок');
        CRUD::column(MainContract::TITLE)->label('Заголовок (Каз)');
        CRUD::column(MainContract::IMG)->label('картинка');
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
        CRUD::setValidation(AwardsRequest::class);

        CRUD::field(MainContract::TITLE)->label('Заголовок');
        CRUD::field(MainContract::TITLE_KZ)->label('Заголовок (Каз)');
        $this->crud->addField([
            'label'        => "Картинка",
            'name'         => MainContract::IMG,
            'type'      => 'upload',
            'upload'    => true,
            'disk' => 'public',
        ]);
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
