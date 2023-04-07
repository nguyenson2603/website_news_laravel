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
                    <th class="column-title">Article Info</th>
                    <th class="column-title">Thumb</th>
                    <th class="column-title">Thể loại</th>
                    <th class="column-title">Kiểu bài viết</th>
                    <th class="column-title">Trạng thái</th>
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
                            $content = Highlight::show($item['content'], $params['search'], 'content');
                            $thumb = Template::showItemThumb($controllerName, $item['thumb']);
                            $status = Template::showItemStatus($controllerName, $id, $item['status']);
                            $type = Template::showItemSelect($controllerName, $id, $item['type'], 'type');;
                            $category = $item['category_name'];
                            $listButtonAction = Template::showButtonAction($controllerName, $id);
                        @endphp
                        <tr class="{{ $class }} pointer">
                            <td class="">{!! $key + 1 !!}</td>
                            <td width="30%">
                                <img src="" alt="" style="width: 50px;">
                                <p><strong>Name: </strong>{!! $name !!}</p>
                                <p><strong>Content: </strong>{!! $content !!}</p>
                            </td>
                            <td width="15%">{!! $thumb !!}</td>
                            <td>{!! $category !!}</td>
                            <td>{!! $type !!}</td>
                            <td>{!! $status !!}</td>
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
