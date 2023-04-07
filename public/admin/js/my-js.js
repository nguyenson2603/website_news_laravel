$(document).ready(function () {
    $('.status-ajax').click(function (e) {
        e.preventDefault();
        let url = $(this).data('url');
        let btn = $(this);
        let curClass = btn.data('class');
        $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            success: function (response) {
                // console.log(response);
                btn.removeClass(curClass);
                btn.addClass(response.status.class);
                btn.html(response.status.name);
                btn.data('url', response.link);
                btn.data('class', response.status.class);
                btn.notify("Success", {
                    position: 'top-center',
                    className: 'success',
                });
            }
        });
    });
    $('.is-home-ajax').click(function (e) {
        e.preventDefault();
        let url = $(this).data('url');
        let btn = $(this);
        let curClass = btn.data('class');
        $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            success: function (response) {
                // console.log(response);
                btn.removeClass(curClass);
                btn.addClass(response.isHome.class);
                btn.html(response.isHome.name);
                btn.data('url', response.link);
                btn.data('class', response.isHome.class);
                btn.notify("Success", {
                    position: 'top-center',
                    className: 'success',
                });
            }
        });
    });
});
