@php
    use App\Helpers\Form as FormTemplate;
    use App\Helpers\Template as Template;
    $formInput = config('zvn.template.form_input');
    $formLabel = config('zvn.template.form_label_edit');
    $elements = [
        [
            'label' => Form::label('password', 'Password', $formLabel),
            'element' => Form::password('password', $formInput),
        ],
        [
            'label' => Form::label('password_confirmation', 'Password Confirmation', $formLabel),
            'element' => Form::password('password_confirmation', $formInput),
        ],
        [
            'type' => 'btn-submit-edit',
            'elements' => [
                Form::hidden('id', @$item['id']),
                Form::hidden('task', 'change-password'),
                Form::hidden('avatar_current', @$item['avatar']),
                Form::submit('Save', ['class' => 'btn btn-info'])
            ],
        ],
    ];
@endphp
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        @include('admin.templates.x_title', ['title' => 'Form Change Password'])
        <div class="x_content">
            <br />
            {!! Form::open([
                'method' => 'POST',
                'url' => route("$controllerName/change-password"),
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
