<?php
return [
    'url' => [
        'prefix_admin'  => 'admin',
        'prefix_news'   => 'news',
    ],
    'format' => [
        'long_time'     => 'H:m:s d-m-Y',
        'short_time'    => 'd-m-Y',
    ],
    'template' => [
        'form_input' => [
            'class'     => 'form-control col-md-7 col-xs-12',
        ],
        'form_ckeditor' => [
            'class'     => 'form-control col-md-7 col-xs-12 ckeditor',
        ],
        'form_label' => [
            'class'     => 'control-label col-md-3 col-sm-3 col-xs-12',
        ],
        'form_label_edit' => [
            'class'     => 'control-label col-md-4 col-sm-3 col-xs-12',
        ],
        'status' => [
            'default'   => ['class' => 'btn-dark', 'name' => 'Không xác định'],
            'all'       => ['class' => 'btn-success', 'name' => 'Tất cả'],
            'active'    => ['class' => 'btn-success', 'name' => 'Kích hoạt'],
            'inactive'  => ['class' => 'btn-primary', 'name' => 'Chưa kích hoạt'],
        ],
        'is_home' => [
            'default'   => ['class' => 'btn-dark', 'name' => 'Không xác định'],
            '0' => ['class' => 'btn-warning', 'name' => 'Không hiển thị'],
            '1' => ['class' => 'btn-success', 'name' => 'Hiển thị'],
        ],
        'display' => [
            'list' => ['name' => 'Dạng danh sách'],
            'grid' => ['name' => 'Dạng lưới'],
        ],
        'type' => [
            'featured' => ['name' => 'Đặc sắc'],
            'normal'  => ['name' => 'Bình thường'],
        ],
        'rss_source' => [
            'vnexpress' => ['name' => 'VNExpress'],
            'thanhnien' => ['name' => 'Thanh Niên'],
            'tuoitre'   => ['name' => 'Tuổi Trẻ'],
        ],
        'level' => [
            'admin' => ['name' => 'Quản trị viên'],
            'member' => ['name' => 'Người dùng'],
        ],
        'search' => [
            'all'           => ['name' => 'Search By All'],
            'id'            => ['name' => 'Search By Id'],
            'name'          => ['name' => 'Search By Name'],
            'username'      => ['name' => 'Search By Username'],
            'fullname'      => ['name' => 'Search By Fullname'],
            'email'         => ['name' => 'Search By Email'],
            'description'   => ['name' => 'Search By Description'],
            'link'          => ['name' => 'Search By Link'],
            'content'       => ['name' => 'Search By Content'],
        ],
        'button' => [
            'edit'   => ['class' => 'btn-success', 'name' => 'Edit',   'icon' => 'fa-pencil', 'route-name' => '/form'],
            'delete' => ['class' => 'btn-danger btn-delete',  'name' => 'Delete', 'icon' => 'fa-trash',  'route-name' => '/delete'],
            'info'   => ['class' => 'btn-info',    'name' => 'View',   'icon' => 'fa-pencil',   'route-name' => '/delete'],
        ],
    ],
    'config' => [
        'search' => [
            'default'   => ['all', 'id'],
            'slider'    => ['all', 'id', 'name', 'description', 'link'],
            'category'  => ['all', 'id', 'name'],
            'article'   => ['all', 'name', 'content'],
            'user'      => ['username', 'email', 'fullname'],
            'rss'       => ['name', 'link'],
        ],
        'button' => [
            'default'   => ['edit', 'delete', 'info'],
            'slider'    => ['edit', 'delete'],
            'category'  => ['edit', 'delete'],
            'article'   => ['edit', 'delete'],
            'user'      => ['edit', 'delete'],
            'rss'       => ['edit', 'delete'],
        ],
    ]
];
