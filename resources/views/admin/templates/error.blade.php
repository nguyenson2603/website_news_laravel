@if ($errors->any())
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><span class="fa fa-warning"></span> Lỗi cú pháp!</h4>
        @foreach ($errors->all() as $error)
            <p class="h5">- {{ $error }}</p>
        @endforeach
    </div>
@endif
