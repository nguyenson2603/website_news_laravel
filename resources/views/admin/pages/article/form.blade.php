@extends('admin.main')
@php
use App\Helpers\Form as FormTemplate;
use App\Helpers\Template as Template;
// echo '<pre style="color: #26004d; font-size: large; font-weight: bold">';
// print_r($item);
// echo '</pre>';
$formInput      = config('zvn.template.form_input');
$formLabel      = config('zvn.template.form_label');
$formInputClass = config('zvn.template.form_input.class');
$formCkeditor   = config('zvn.template.form_ckeditor');
$options = [
    'active' => config('zvn.template.status.active.name'),
    'inactive' => config('zvn.template.status.inactive.name'),
];
$elements = [
    [
        'label' => Form::label('name', 'Name', $formLabel),
        'element' => Form::text('name', @$item['name'], $formInput),
    ],
    [
        'label' => Form::label('content', 'Content', $formLabel),
        'element' => Form::textarea('content', @$item['content'], $formCkeditor),
    ],
    [
        'label' => Form::label('status', 'Status', $formLabel),
        'element' => Form::select('status', $options, @$item['status'], ['class' => $formInputClass, 'placeholder' => 'Choose...']),
    ],
    [
        'label' => Form::label('category_id', 'Category', $formLabel),
        'element' => Form::select('category_id', $category, @$item['category_id'], ['class' => $formInputClass, 'placeholder' => 'Choose...']),
    ],
    [
        'label' => Form::label('thumb', 'Thumb', $formLabel),
        'element' => Form::file('thumb', $formInput),
        'thumb' => isset($item['thumb']) ? Template::showItemThumb($controllerName, $item['thumb']) : '',
        'type' => 'thumb',
    ],
    [
        'type' => 'btn-submit',
        'elements' => [Form::hidden('id', @$item['id']), Form::hidden('thumb_current', @$item['thumb']), Form::submit('Save', ['class' => 'btn btn-info'])],
    ],
];
@endphp
@section('content')
    <div role="main">
        @include('admin.templates.page_header', ['pageIndex' => false])
        @include('admin.templates.error')
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Thêm mới </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        {!! Form::open([
                            'method' => 'POST',
                            'url' => route("$controllerName/save"),
                            'accept-charset' => 'UTF-8',
                            'enctype' => 'multipart/form-data',
                            'class' => 'form-horizontal form-label-left',
                            'id' => 'main-form',
                        ]) !!}
                        {!! FormTemplate::show($elements) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
