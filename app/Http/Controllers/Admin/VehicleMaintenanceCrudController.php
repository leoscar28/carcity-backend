<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Contracts\MainContract;
use App\Http\Requests\VehicleMaintenanceRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class VehicleMaintenanceCrudController extends CrudController
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
    public function setup()
    {
        CRUD::setModel(\App\Models\VehicleMaintenance::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/vehicle-maintenance');
        CRUD::setEntityNameStrings('Услугу', 'Обслуживанию Автотранспорта');
    }

    protected function setupShowOperation(): void
    {
        CRUD::column(MainContract::ID)->label('ID');
        CRUD::column(MainContract::TITLE)->label('Заголовок');
        CRUD::column(MainContract::TITLE_KZ)->label('Заголовок (Каз)');
        CRUD::column(MainContract::IMG)->label('Иконка');
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
        CRUD::column(MainContract::ID)->label('ID');
        CRUD::column(MainContract::TITLE)->label('Заголовок');
        CRUD::column(MainContract::TITLE_KZ)->label('Заголовок (Каз)');
        CRUD::column(MainContract::IMG)->label('Иконка');
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
        CRUD::setValidation(VehicleMaintenanceRequest::class);

        CRUD::field(MainContract::TITLE)->label('Заголовок');
        CRUD::field(MainContract::TITLE_KZ)->label('Заголовок (Каз)');
        $this->crud->addField([
            'label'        => "Иконка",
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
