@if (session('news_notify'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><span class="fa fa-drupal"></span> Thông báo!</h4>
        <p class="h5">{{ session('news_notify') }}</p>
    </div>
@endif
