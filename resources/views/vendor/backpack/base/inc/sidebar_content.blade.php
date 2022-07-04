<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('dashboard') }}">
        <i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}
    </a>
</li>
<li class='nav-item'>
    <a class='nav-link' href='{{ backpack_url('user') }}'>
        <i class='nav-icon las la-user-circle'></i> Пользователи
    </a>
</li>
<li class='nav-item'>
    <a class='nav-link' href='{{ backpack_url('user-bin') }}'>
        <i class='nav-icon las la-user-circle'></i> ЭЦП бины
    </a>
</li>
<li class='nav-item'>
    <a class='nav-link' href='{{ backpack_url('position') }}'>
        <i class='nav-icon las la-user-tie'></i> Должности
    </a>
</li>
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#">
        <i class="nav-icon las la-feather-alt"></i> Статусы
    </a>
    <ul class="nav-dropdown-items">
        <li class='nav-item'>
            <a class='nav-link' href='{{ backpack_url('completion-status') }}'>
                <i class='nav-icon las la-feather'></i> Акт выполненных работ
            </a>
        </li>
        <li class='nav-item'>
            <a class='nav-link' href='{{ backpack_url('application-status') }}'>
                <i class='nav-icon las la-feather'></i> Договора и приложения
            </a>
        </li>
        <li class='nav-item'>
            <a class='nav-link' href='{{ backpack_url('invoice-status') }}'>
                <i class='nav-icon las la-feather'></i> Счет на оплату
            </a>
        </li>
    </ul>
</li>

<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#">
        <i class="nav-icon las la-building"></i> Реестр помещений
    </a>
    <ul class="nav-dropdown-items">
        <li class='nav-item'>
            <a class='nav-link' href='{{ backpack_url('tier') }}'>
                <i class='nav-icon las la-building'></i> Ярусы
            </a>
        </li>
        <li class='nav-item'>
            <a class='nav-link' href='{{ backpack_url('room-type') }}'>
                <i class='nav-icon las la-sort'></i> Тип помещения
            </a>
        </li>
        <li class='nav-item'>
            <a class='nav-link' href='{{ backpack_url('room') }}'>
                <i class='nav-icon las la-sort'></i> Помещения
            </a>
        </li>
    </ul>
</li>

<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#">
        <i class="nav-icon las la-globe-americas"></i> Веб-сайт
    </a>
    <ul class="nav-dropdown-items">
        <li class='nav-item'>
            <a class='nav-link' href='{{ backpack_url('slider') }}'>
                <i class='nav-icon lab la-slideshare'></i> Слайдер
            </a>
        </li>
        <li class='nav-item'>
            <a class='nav-link' href='{{ backpack_url('slider-detail') }}'>
                <i class='nav-icon lab la-slideshare'></i> Слайдер детали
            </a>
        </li>
        <li class='nav-item'>
            <a class='nav-link' href='{{ backpack_url('about') }}'>
                <i class='nav-icon las la-address-card'></i> О нас
            </a>
        </li>
        <li class='nav-item'>
            <a class='nav-link' href='{{ backpack_url('about-option') }}'>
                <i class='nav-icon las la-address-card'></i> О нас пункты
            </a>
        </li>
        <li class='nav-item'>
            <a class='nav-link' href='{{ backpack_url('infrastructure') }}'>
                <i class='nav-icon lab la-ubuntu'></i> Инфраструктура
            </a>
        </li>
        <li class='nav-item'>
            <a class='nav-link' href='{{ backpack_url('infrastructure-option') }}'>
                <i class='nav-icon lab la-ubuntu'></i> Инфраструктура пункты
            </a>
        </li>
        <li class='nav-item'>
            <a class='nav-link' href='{{ backpack_url('vehicle-maintenance') }}'>
                <i class='nav-icon las la-car-side'></i> Обслуживанию Автотранспорта
            </a>
        </li>
        <li class='nav-item'>
            <a class='nav-link' href='{{ backpack_url('contact') }}'>
                <i class='nav-icon las la-id-card'></i> Контакты
            </a>
        </li>
    </ul>
</li>

