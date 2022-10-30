<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Contracts\MainContract;
use App\Http\Requests\TierRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class TierCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Tier::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/tier');
        CRUD::setEntityNameStrings('Ярус', 'Ярусы');
    }

    protected function setupShowOperation()
    {
        CRUD::column(MainContract::ID)->label('ID');
        CRUD::column(MainContract::TITLE)->label('Название яруса на русском');
        CRUD::column(MainContract::TITLE_KZ)->label('Название яруса на казахском');
        CRUD::column(MainContract::STATUS)->type('select_from_array')
            ->label('Статус')->options([
                0   =>  'Отключен',
                1   =>  'Включен'
            ]);
    }

    protected function setupListOperation()
    {
        CRUD::column(MainContract::ID)->label('ID');
        CRUD::column(MainContract::TITLE)->label('Название яруса на русском');
        CRUD::column(MainContract::TITLE_KZ)->label('Название яруса на казахском');
        CRUD::column(MainContract::STATUS)->type('select_from_array')
            ->label('Статус')->options([
                0   =>  'Отключен',
                1   =>  'Включен'
            ]);
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(TierRequest::class);

        CRUD::field(MainContract::TITLE)->label('Название яруса на русском');
        CRUD::field(MainContract::TITLE_KZ)->label('Название яруса на казахском');
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
