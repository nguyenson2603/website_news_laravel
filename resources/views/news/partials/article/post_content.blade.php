@php
    use App\Helpers\Template;
    use App\Helpers\URL;
    $name = $item['name'];
    $categoryName = @$item['category_name'];
    $linkCategory = URL::linkCategory(@$item['category_id'], @$item['category_name']);
    $linkArticle = URL::linkArticle(@$item['id'], @$item['name']);
    $created_by = $item['created_by'];
    $created = Template::showDatetimeFrontend($item['created']);
    if ($length === 'full') {
        $content = $item['content'];
    } else {
        $content = Template::showContent($item['content'], $length);
    }
@endphp
<div class="post_content">
    @if (isset($categoryName))
        <div class="post_category cat_technology ">
            <a href="{{ $linkCategory }}">{{ $categoryName }}</a>
        </div>
    @endif
    <div class="post_title"><a href="{{ $linkArticle }}">
            {{ $name }}
        </a>
    </div>
    <div class="post_info d-flex flex-row align-items-center justify-content-start">
        <div class="post_author d-flex flex-row align-items-center justify-content-start">
            <div class="post_author_name"><a href="{{ $linkArticle }}">{{ $created_by }}</a>
            </div>
        </div>
        <div class="post_date"><a href="{{ $linkArticle }}">{{ $created }}</a></div>
    </div>
    <div class="post_text">
        <p>{!! $content !!}</p>
    </div>
</div>
