@extends('admin.main')
@section('content')
    @include('admin.templates.page_header', ['pageIndex' => false])
    @include('admin.templates.error')
    @if (isset($item['id']))
    <div class="row">
        @include('admin.pages.user.form_info')
        <div class="col-md-6 col-sm-12 col-xs-12">
            @include('admin.pages.user.form_change_password')
            @include('admin.pages.user.form_change_level')
        </div>
    </div>
    @else
        @include('admin.pages.user.form_add')
    @endif
@endsection
