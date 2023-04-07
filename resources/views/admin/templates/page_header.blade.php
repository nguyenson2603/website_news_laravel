@php
$link = route($controllerName . '/form');
$class = 'btn-success';
$icon = 'fa-plus-circle';
$button = 'Thêm mới';
if ($pageIndex == false) {
    $link = route($controllerName);
    $class = 'btn-warning';
    $icon = 'fa-arrow-left';
    $button = 'Quay lại';
}
$pageTitle = 'Quản lý ' . Str::ucfirst($controllerName);
$pageButton = sprintf(
    '
    <a href="%s" class="btn %s"><i class="fa %s"></i> %s</a>
    ',
    $link,
    $class,
    $icon,
    $button,
);
@endphp
<div class="page-header zvn-page-header clearfix">
    <div class="zvn-page-header-title">
        <h3>{!! $pageTitle !!}</h3>
    </div>
    <div class="zvn-add-new pull-right">
        {!! $pageButton !!}
    </div>
</div>
