@php
    use App\Helpers\Form as FormTemplate;
    use App\Helpers\Template as Template;
    $formInput = config('zvn.template.form_input');
    $formLabel = config('zvn.template.form_label');
    $formInputClass = config('zvn.template.form_input.class');
    $statusValue = [
        'active' => config('zvn.template.status.active.name'),
        'inactive' => config('zvn.template.status.inactive.name'),
    ];
    $levelValue = [
        'admin' => config('zvn.template.level.admin.name'),
        'member' => config('zvn.template.level.member.name'),
    ];
    $elements = [
        [
            'label' => Form::label('username', 'Username', $formLabel),
            'element' => Form::text('username', @$item['username'], $formInput),
        ],
        [
            'label' => Form::label('email', 'Email', $formLabel),
            'element' => Form::text('email', @$item['email'], $formInput),
        ],
        [
            'label' => Form::label('fullname', 'Fullname', $formLabel),
            'element' => Form::text('fullname', @$item['fullname'], $formInput),
        ],
        [
            'label' => Form::label('status', 'Status', $formLabel),
            'element' => Form::select('status', $statusValue, @$item['status'], ['class' => $formInputClass, 'placeholder' => 'Choose...']),
        ],
        [
            'label' => Form::label('avatar', 'Avatar', $formLabel),
            'element' => Form::file('avatar', $formInput),
            'avatar' => isset($item['avatar']) ? Template::showItemAvatar($controllerName, $item['avatar']) : '',
            'type' => 'avatar',
        ],
        [
            'type' => 'btn-submit',
            'elements' => [
                Form::hidden('id', @$item['id']),
                Form::hidden('task', 'edit'),
                Form::hidden('avatar_current', @$item['avatar']),
                Form::submit('Save', ['class' => 'btn btn-info'])
            ],
        ],
    ];
@endphp
<div class="col-md-6 col-sm-12 col-xs-12">
    <div class="x_panel">
        @include('admin.templates.x_title', ['title' => 'Form Edit Info'])
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
