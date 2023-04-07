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
                    <th class="column-title">Name</th>
                    <th class="column-title">Trạng thái</th>
                    <th class="column-title">Hiển thị Home</th>
                    <th class="column-title">Định dạng hiển thị</th>
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
                            $name = Highlight::show($item['name'], $params['search'], 'name');
                            $status = Template::showItemStatus($controllerName, $id, $item['status']);
                            $isHome = Template::showItemIsHome($controllerName, $id, $item['is_home']);
                            $display = Template::showItemSelect($controllerName, $id, $item['display'], 'display');
                            $createdHistory = Template::showItemHistory($item['created_by'], $item['created']);
                            $modifiedHistory = Template::showItemHistory($item['modified_by'], $item['modified']);
                            $listButtonAction = Template::showButtonAction($controllerName, $id);
                        @endphp
                        <tr class="{{ $class }} pointer">
                            <td class="">{!! $key + 1 !!}</td>
                            <td class="h4" width="25%">{!! $name !!}</td>
                            <td>{!! $status !!}</td>
                            <td>{!! $isHome !!}</td>
                            <td>{!! $display !!}</td>
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
