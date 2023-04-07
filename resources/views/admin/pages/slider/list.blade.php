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
                    <th class="column-title">Slider Info</th>
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
                            $name = Highlight::show($item['name'], $params['search'], 'name');
                            $description = Highlight::show($item['description'], $params['search'], 'description');
                            $link = Highlight::show($item['link'], $params['search'], 'link');
                            $thumb = Template::showItemThumb($controllerName, $item['thumb']);
                            $status = Template::showItemStatus($controllerName, $id, $item['status']);
                            $createdHistory = Template::showItemHistory($item['created_by'], $item['created']);
                            $modifiedHistory = Template::showItemHistory($item['modified_by'], $item['modified']);
                            $listButtonAction = Template::showButtonAction($controllerName, $id);
                        @endphp
                        <tr class="{{ $class }} pointer">
                            <td class="">{!! $key + 1 !!}</td>
                            <td width="40%">
                                <img src="" alt="" style="width: 50px;">
                                <p><strong>Name: </strong>{!! $name !!}</p>
                                <p><strong>Description: </strong>{!! $description !!}</p>
                                <p><strong>Link: </strong>{!! $link !!}</p>
                                {!! $thumb !!}
                            </td>
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
