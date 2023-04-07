@extends('news.main')
@section('content')
    {{-- @include('news.block.slider') --}}
    <!-- Content Container -->
    <div class="content_container">
        <div class="container">
            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-9">
                    <div class="main_content">
                        <h3>Bạn không có quyền truy cập vào trang web này!!</h3>
                    </div>
                </div>
                <!-- Sidebar -->
                <div class="col-lg-3">
                    <div class="sidebar">
                        <!-- Latest Posts -->
                        @include('news.block.latest_posts', ['items' => $itemsLatest])
                        <!-- Advertisement -->
                        @include('news.block.advertisement', ['itemsAdvertisement' => []])
                        <!-- Most Viewed -->
                        @include('news.block.most_viewed', ['itemsMostViewed' => []])
                        <!-- Tags -->
                        @include('news.block.tags', ['itemsTags' => []])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
