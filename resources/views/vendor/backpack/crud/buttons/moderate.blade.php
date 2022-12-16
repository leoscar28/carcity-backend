@if ($crud->hasAccess('update'))
    <a href="{{ url($crud->route.'/moderate') }} " class="btn btn-xs btn-default"><i class="la la-info"></i> Отчет</a>
@endif
