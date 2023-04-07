<div class="posts">
    @foreach ($item['related_articles'] as $value)
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
</div>
