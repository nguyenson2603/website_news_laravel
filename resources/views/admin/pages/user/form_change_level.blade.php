@php
    use App\Helpers\Form as FormTemplate;
    use App\Helpers\Template as Template;
    $formInput = config('zvn.template.form_input');
    $formLabel = config('zvn.template.form_label_edit');
    $formInputClass = config('zvn.template.form_input.class');
    $levelValue = [
        'admin' => config('zvn.template.level.admin.name'),
        'member' => config('zvn.template.level.member.name'),
    ];
    $elements = [
        [
            'label' => Form::label('level', 'Level', $formLabel),
            'element' => Form::select('level', $levelValue, @$item['level'], ['class' => $formInputClass, 'placeholder' => 'Choose...']),
        ],
        [
            'type' => 'btn-submit-edit',
            'elements' => [Form::hidden('id', @$item['id']), Form::hidden('task', 'change-level'), Form::hidden('avatar_current', @$item['avatar']), Form::submit('Save', ['class' => 'btn btn-info'])],
        ],
    ];
@endphp
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        @include('admin.templates.x_title', ['title' => 'Form Change Level'])
        <div class="x_content">
            <br />
            {!! Form::open([
                'method' => 'POST',
                'url' => route("$controllerName/change-level"),
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
