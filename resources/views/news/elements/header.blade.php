@php
    use App\Models\CategoryModel as CategoryModel;
    use App\Helpers\URL;
    $categoryModel = new CategoryModel();
    $items = $categoryModel->listItems(null, ['task' => 'news-list-items']);
    $xhtmlMenu = null;
    $xhtmlMenuMobile = null;
    $xhtmlMenuUser = null;
    if (count($items) > 0) {
        $xhtmlMenu .= '<nav class="main_nav">
            <ul class="main_nav_list d-flex flex-row align-items-center justify-content-start">';
        $xhtmlMenuMobile .= '<nav class="menu_nav">
            <ul class="menu_mm">';
        $curCategoryId = Route::input('category_id');
        foreach ($items as $item) {
            $link = URL::linkCategory($item['id'], $item['name']);
            $classActive = $curCategoryId == $item['id'] ? 'class="active"' : '';
            $xhtmlMenu .= sprintf('<li %s><a href="%s">%s</a></li>', $classActive, $link, $item['name']);
            $xhtmlMenuMobile .= sprintf('<li class="menu_mm"><a href="%s">%s</a></li>', $link, $item['name']);
        }
        if (!session('userInfo')) {
            $xhtmlMenuUser = sprintf('<li><a href="%s">%s</a></li>', route('auth/login'), 'ĐĂNG NHẬP');
            $xhtmlMenuMobileUser = sprintf('<li class="menu_mm"><a href="%s">%s</a></li>', route('auth/login'), 'ĐĂNG NHẬP');
        } else {
            $xhtmlMenuUser = sprintf('<li><a href="%s">%s</a></li>', route('auth/logout'), 'ĐĂNG XUẤT');
            $xhtmlMenuMobileUser = sprintf('<li class="menu_mm"><a href="%s">%s</a></li>', route('auth/logout'), 'ĐĂNG XUẤT');
        }
        $xhtmlMenuRss = sprintf('<li><a href="%s">%s</a></li>', route('rss/news'), 'TIN TỨC TỔNG HỢP');
        $xhtmlMenuMobileRss = sprintf('<li class="menu_mm"><a href="%s">%s</a></li>', route('rss/news'), 'TIN TỨC TỔNG HỢP');

        $xhtmlMenu .= $xhtmlMenuRss . $xhtmlMenuUser . '</ul></nav>';
        $xhtmlMenuMobile .= $xhtmlMenuMobileRss . $xhtmlMenuMobileUser . '</ul></nav>';
    }
@endphp
<header class="header">
    <!-- Header Content -->
    <div class="header_content_container">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="header_content d-flex flex-row align-items-center justfy-content-start">
                        <div class="logo_container">
                            <a href="{{ route('home') }}">
                                <div class="logo"><span>ZEND</span>VN</div>
                            </a>
                        </div>
                        <div class="header_extra ml-auto d-flex flex-row align-items-center justify-content-start">
                            <a href="#">
                                <div class="background_image"
                                    style="background-image:url({{ asset('newss/images/zendvn-online.png') }});background-size: contain">
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header Navigation & Search -->
    <div class="header_nav_container" id="header">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="header_nav_content d-flex flex-row align-items-center justify-content-start">
                        <!-- Logo -->
                        <div class="logo_container">
                            <a href="#">
                                <div class="logo"><span>ZEND</span>VN</div>
                            </a>
                        </div>
                        <!-- Navigation -->
                        {!! $xhtmlMenu !!}
                        <!-- Hamburger -->
                        <div class="hamburger ml-auto menu_mm"><i class="fa fa-bars  trans_200 menu_mm"
                                aria-hidden="true"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Menu -->
<div class="menu d-flex flex-column align-items-end justify-content-start text-right menu_mm trans_400">
    <div class="menu_close_container">
        <div class="menu_close">
            <div></div>
            <div></div>
        </div>
    </div>
    {!! $xhtmlMenuMobile !!}
</div>
