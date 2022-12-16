@extends(backpack_view('blank'))

@php
    $defaultBreadcrumbs = [
      trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
      'Пользовател' => '/user',
      trans('backpack::crud.preview') => false,
    ];

    // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('content')
    <div class="row">
        <section class="container-fluid d-print-none">
            <h2>
                <span class="text-capitalize">Отчет</span>
            </h2>
        </section>
        <form method="post" action="/user/report">
            @csrf
            <div class="card">
                <div class="card-body row">
                    <div class="form-group col-sm-6" element="div">    <label>От</label>
                        <input type="date" name="from" value="" class="form-control">
                    </div>
                    <div class="form-group col-sm-6" element="div">    <label>До</label>
                        <input type="date" name="to" value="" class="form-control">
                    </div>
                    <div class="form-group col-sm-12">
                        <button type="submit" class="btn btn-success"><span class="la la-print"></span> &nbsp;Выгрузить отчет</button>
                        <a href="/user" class="btn btn-default"><span class="la la-ban"></span> &nbsp;Отменить</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
