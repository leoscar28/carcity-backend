<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Contracts\MainContract;
use App\Http\Requests\DictionarySparePartRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class DictionarySparePartCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class DictionarySparePartCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\DictionarySparePart::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/dictionary-spare-part');
        CRUD::setEntityNameStrings('запчасть', 'запчасти');

        $request = $this->crud->getRequest();
        if (!$request->has('order')) {
            $request->merge(['order' => [
                [
                    'column' => MainContract::NAME,
                    'dir' => 'asc'
                ]
            ]]);
        }
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->denyAccess('show');
        CRUD::column(MainContract::NAME)->label('Название');
        CRUD::column(MainContract::STATUS)->type('select_from_array')
            ->label('Статус')->options([
                0   =>  'Отключен',
                1   =>  'Включен'
            ]);
        CRUD::column(MainContract::FOR_MENU)->type('select_from_array')
            ->label('В меню')->options([
                0   =>  'Отключен',
                1   =>  'Включен'
            ]);

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(DictionarySparePartRequest::class);
        CRUD::field(MainContract::NAME)->label('Название');
        CRUD::field(MainContract::STATUS)->type('select_from_array')
            ->label('Статус')->options([
                0   =>  'Отключен',
                1   =>  'Включен'
            ])->default(1);
        CRUD::field(MainContract::FOR_MENU)->type('select_from_array')
            ->label('В меню')->options([
                0   =>  'Отключен',
                1   =>  'Включен'
            ])->default(0);

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
