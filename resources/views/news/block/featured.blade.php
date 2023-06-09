<div class="featured">
    <div class="featured_title">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="section_title_container d-flex flex-row align-items-start justify-content-start">
                        <div>
                            <div class="section_title">Nổi bậc</div>
                        </div>
                        <div class="section_bar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Featured Title -->
    <div class="row">
        <div class="col-lg-8">
            <!-- Post -->
            <div class="post_item post_v_large d-flex flex-column align-items-start justify-content-start">
                <div class="post_item post_v_small d-flex flex-column align-items-start justify-content-start">
                    @include('news.partials.article.post_image', ['item' => $items[0]])
                    @include('news.partials.article.post_content', ['item' => $items[0], 'length' => 500])
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            @php unset($items[0]) @endphp
            @foreach ($items as $item)
                <div>
                    <div class="post_item post_v_small d-flex flex-column align-items-start justify-content-start">
                        @include('news.partials.article.post_image', ['item' => $item])
                        @include('news.partials.article.post_content', ['item' => $item, 'length' => 0])
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
