<div class="technology">
    <div class="section_title_container d-flex flex-row align-items-start justify-content-start">
        <div>
            <div class="section_title">{{ $item['name'] }}</div>
        </div>
        <div class="section_bar"></div>
    </div>
    <div class="technology_content">
        @foreach ($item['article'] as $value)
            <div class="post_item post_h_large">
                <div class="row">
                    <div class="col-lg-5">
                        @include('news.partials.article.post_image', ['item' => $value])
                    </div>
                    <div class="col-lg-7">
                        @include('news.partials.article.post_content', ['item' => $value, 'length' => 200])
                    </div>
                </div>
            </div>
        @endforeach
        <div class="row">
            <div class="home_button mx-auto text-center"><a href="the-loai/the-thao-1.html">Xem
                    thêm</a></div>
        </div>
    </div>
</div>
