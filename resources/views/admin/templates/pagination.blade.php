@php
$totalItems = $items->total();
$totalPages = $items->lastPage();
$totalItemsPerPage = $items->perPage();
@endphp
<div class="x_content">
    <div class="row">
        <div class="col-md-6">
            <p class="m-b-0 h4">
                <span class="label label-info label-pagination">Có {{ $totalItemsPerPage }} phần tử trên trang</span>
                <span class="label label-danger label-pagination">Tổng: {{ $totalItems }} phần tử</span>
                <span class="label label-warning label-pagination">Tổng: {{ $totalPages }} trang</span>
            </p>
        </div>
        <div class="col-md-6">
            {{-- {!! $items->links('pagination.backend.pagination_zvn') !!} --}}
            {!! $items->appends(request()->input())->links('pagination.backend.pagination_zvn') !!}
        </div>
    </div>
</div>
