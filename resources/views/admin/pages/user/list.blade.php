@php
use App\Helpers\Template as Template;
use App\Helpers\Highlight as Highlight;
@endphp
<div class="x_content">
    <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action">
            <thead>
                <tr class="headings">
                    <th class="column-title">#</th>
                    <th class="column-title">Username</th>
                    <th class="column-title">Email</th>
                    <th class="column-title">Fullname</th>
                    <th class="column-title">Level</th>
                    <th class="column-title">Avatar</th>
                    <th class="column-title">Trạng thái</th>
                    <th class="column-title">Tạo mới</th>
                    <th class="column-title">Chỉnh sửa</th>
                    <th class="column-title">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @if (count($items) > 0)
                    @foreach ($items as $key => $item)
                        @php
                            $class = $key % 2 == 0 ? 'even' : 'odd';
                            $id = $item['id'];
                            $username = Highlight::show($item['username'], $params['search'], 'username');
                            $fullname = Highlight::show($item['fullname'], $params['search'], 'fullname');
                            $email = Highlight::show($item['email'], $params['search'], 'email');
                            $level = Template::showItemSelect($controllerName, $id, $item['level'], 'level');
                            $avatar = Template::showItemThumb($controllerName, $item['avatar']);
                            $status = Template::showItemStatus($controllerName, $id, $item['status']);
                            $createdHistory = Template::showItemHistory($item['created_by'], $item['created']);
                            $modifiedHistory = Template::showItemHistory($item['modified_by'], $item['modified']);
                            $listButtonAction = Template::showButtonAction($controllerName, $id);
                        @endphp
                        <tr class="{{ $class }} pointer">
                            <td class="">{!! $key + 1 !!}</td>
                            <td width="10%">{!! $username !!}</td>
                            <td width="10%">{!! $email !!}</td>
                            <td width="10%">{!! $fullname !!}</td>
                            <td width="15%">{!! $level !!}</td>
                            <td width="15%">{!! $avatar !!}</td>
                            <td>{!! $status !!}</td>
                            <td>{!! $createdHistory !!}</td>
                            <td>{!! $modifiedHistory !!}</td>
                            <td class="last">
                                {!! $listButtonAction !!}
                            </td>
                        </tr>
                    @endforeach
                @else
                    @include('admin.templates.list_empty', ['colpan' => 6])
                @endif
            </tbody>
        </table>
    </div>
</div>
