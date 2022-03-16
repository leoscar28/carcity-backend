<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Contracts\MainContract;
use App\Http\Requests\User\UserCrudCreateRequest;
use App\Http\Requests\User\UserCrudUpdateRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class UserCrudController extends CrudController
{
    use ListOperation;
    use CreateOperation { store as traitStore; }
    use UpdateOperation;
    use ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings('Пользователь', 'Пользователи');
    }

    public function store()
    {
        $this->crud->addField(['type' => 'hidden', 'name' => MainContract::TOKEN]);
        $this->crud->getRequest()->request->add([MainContract::TOKEN    =>  Str::random()]);
        $response   =   $this->traitStore();
        return $response;
    }

    protected function setupShowOperation()
    {
        CRUD::column(MainContract::ID)->label('ID');
        CRUD::column(MainContract::ALIAS)->label('Логин');
        CRUD::column(MainContract::NAME)->label('Имя');
        CRUD::column(MainContract::SURNAME)->label('Фамилия');
        CRUD::column(MainContract::LAST_NAME)->label('Отчество');
        CRUD::column(MainContract::BIRTHDATE)->label('Дата рождения')->type('date');
        CRUD::column(MainContract::HIDE_BIRTHDATE)->type('select_from_array')
            ->label('Скрыть дату рождения')->options([
                0   =>  'Отключен',
                1   =>  'Включен'
            ]);
        CRUD::column(MainContract::ROLE_ID)->type('select_from_array')
            ->label('Роль')->options([
                1   =>  'Пользователь',
                2   =>  'Администратор',
                3   =>  'Менеджер',
                4   =>  'Руководитель',
                5   =>  'Арендатор',
            ]);
        CRUD::column(MainContract::COMPANY)->label('Компания');
        CRUD::column(MainContract::BIN)->label('БИН');
        CRUD::column(MainContract::STATUS)->type('select_from_array')
            ->label('Статус')->options([
                0   =>  'Отключен',
                1   =>  'Включен'
            ]);
    }

    protected function setupListOperation()
    {
        CRUD::column(MainContract::ID)->label('ID');
        CRUD::field(MainContract::ROLE_ID)->type('select_from_array')
            ->label('Роль')->options([
                1   =>  'Пользователь',
                2   =>  'Администратор',
                3   =>  'Менеджер',
                4   =>  'Руководитель',
                5   =>  'Арендатор',
            ])->default(1);
        CRUD::column(MainContract::NAME)->label('Имя');
        CRUD::column(MainContract::EMAIL)->label('Эл.почта');
        CRUD::column(MainContract::STATUS)->type('select_from_array')
            ->label('Статус')->options([
                0   =>  'Отключен',
                1   =>  'Включен'
            ]);
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(UserCrudCreateRequest::class);
        CRUD::field(MainContract::ALIAS)->label('Логин');
        CRUD::field(MainContract::NAME)->label('Имя');
        CRUD::field(MainContract::SURNAME)->label('Фамилия');
        CRUD::field(MainContract::LAST_NAME)->label('Отчество');
        CRUD::field(MainContract::BIRTHDATE)->label('Дата рождения')->type('date');
        CRUD::field(MainContract::HIDE_BIRTHDATE)->type('select_from_array')
            ->label('Скрыть дату рождения')->options([
                0   =>  'Отключен',
                1   =>  'Включен'
            ]);
        CRUD::field(MainContract::ROLE_ID)->type('select_from_array')
            ->label('Роль')->options([
                1   =>  'Пользователь',
                2   =>  'Администратор',
                3   =>  'Менеджер',
                4   =>  'Руководитель',
                5   =>  'Арендатор',
            ])->default(1);
        CRUD::field(MainContract::COMPANY)->label('Компания');
        CRUD::field(MainContract::BIN)->label('БИН');
        CRUD::field(MainContract::EMAIL)->label('Эл.почта');
        CRUD::field(MainContract::PHONE)->label('Номер телефона');
        CRUD::field(MainContract::PASSWORD)->label('Пароль');
        CRUD::field(MainContract::STATUS)->type('select_from_array')
            ->label('Статус')->options([
                0   =>  'Отключен',
                1   =>  'Включен'
            ])->default(1);
    }

    protected function setupUpdateOperation()
    {
        CRUD::setValidation(UserCrudUpdateRequest::class);
        CRUD::field(MainContract::ALIAS)->label('Логин');
        CRUD::field(MainContract::NAME)->label('Имя');
        CRUD::field(MainContract::SURNAME)->label('Фамилия');
        CRUD::field(MainContract::LAST_NAME)->label('Отчество');
        CRUD::field(MainContract::BIRTHDATE)->label('Дата рождения')->type('date');
        CRUD::field(MainContract::HIDE_BIRTHDATE)->type('select_from_array')
            ->label('Скрыть дату рождения')->options([
                0   =>  'Отключен',
                1   =>  'Включен'
            ]);
        CRUD::field(MainContract::ROLE_ID)->type('select_from_array')
            ->label('Роль')->options([
                1   =>  'Пользователь',
                2   =>  'Администратор',
                3   =>  'Менеджер',
                4   =>  'Руководитель',
                5   =>  'Арендатор',
            ])->default(1);
        CRUD::field(MainContract::COMPANY)->label('Компания');
        CRUD::field(MainContract::BIN)->label('БИН');
        CRUD::field(MainContract::STATUS)->type('select_from_array')
            ->label('Статус')->options([
                0   =>  'Отключен',
                1   =>  'Включен'
            ])->default(1);
    }
}
