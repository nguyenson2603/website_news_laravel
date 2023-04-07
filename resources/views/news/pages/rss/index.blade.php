@extends('news.main')
@section('content')
    <div class="section-category">
        @include('news.block.breadcrumb', ['item' => ['name' => $title]])
        <div class="content_container container_category">
            <div class="featured_title">
                <div class="container">
                    <div class="row">
                        <!-- Main Content -->
                        <div class="col-lg-8">
                            @include('news.pages.rss.child-index.list', ['items' => $items])
                        </div>
                        <div class="col-lg-4">
                            <h3 class="font-weight-bold">Giá Vàng</h3>
                            <div id="box-gold" class="d-flex align-items-center justify-content-center" data-url="{{ route('rss/get-gold') }}">
                                <img src="{{ asset('images/gif/Curve-Loading.gif') }}" alt="" width="80%">
                            </div>
                            <h3 class="font-weight-bold">Giá Coin</h3>
                            <div id="box-coin" class="d-flex align-items-center justify-content-center" data-url="{{ route('rss/get-coin') }}">
                                <img src="{{ asset('images/gif/Curve-Loading.gif') }}" alt="" width="80%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
