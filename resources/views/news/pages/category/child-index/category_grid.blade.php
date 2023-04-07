<div class="posts">
    <div class="col-lg-11">
        <div class="row">
            @foreach ($item['article'] as $value)
                <div class="col-lg-6">
                    <div class="post_item post_v_small d-flex flex-column align-items-start justify-content-start">
                        @include('news.partials.article.post_image', ['item' => $value])
                        @include('news.partials.article.post_content', ['item' => $value, 'length' => 250])
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
