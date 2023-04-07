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
                    <th class="column-title">Link</th>
                    <th class="column-title">Ordering</th>
                    <th class="column-title">Source</th>
                    <th class="column-title">Status</th>
                    <th class="column-title">Created</th>
                    <th class="column-title">Modified</th>
                    <th class="column-title">Action</th>
                </tr>
            </thead>
            <tbody>
                @if (count($items) > 0)
                    @foreach ($items as $key => $item)
                        @php
                            $class = $key % 2 == 0 ? 'even' : 'odd';
                            $id = $item['id'];
                            $name = Highlight::show($item['name'], $params['search'], 'name');
                            $link = Highlight::show($item['link'], $params['search'], 'link');
                            $ordering = $item['ordering'];
                            $source = $item['source'];
                            $status = Template::showItemStatus($controllerName, $id, $item['status']);
                            $createdHistory = Template::showItemHistory($item['created_by'], $item['created']);
                            $modifiedHistory = Template::showItemHistory($item['modified_by'], $item['modified']);
                            $listButtonAction = Template::showButtonAction($controllerName, $id);
                        @endphp
                        <tr class="{{ $class }} pointer">
                            <td class="">{!! $key + 1 !!}</td>
                            <td>{!! $name !!}</td>
                            <td>{!! $link !!}</td>
                            <td>{!! $ordering !!}</td>
                            <td>{!! $source !!}</td>
                            <td>{!! $status !!}</td>
                            <td>{!! $createdHistory !!}</td>
                            <td>{!! $modifiedHistory !!}</td>
                            <td class="last">
                                {!! $listButtonAction !!}
                            </td>
                        </tr>
                    @endforeach
                @else
                    @include('admin.templates.list_empty', ['colpan' => 9])
                @endif
            </tbody>
        </table>
    </div>
</div>
