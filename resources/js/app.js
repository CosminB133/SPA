require('./bootstrap');

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {

    $('[data-translate]').each(function () {
            $(this).text(trans($(this).text()));
        }
    );

    $('input[type = "submit"]').each(function () {
            $(this).attr('value', trans($(this).attr('value')));
        }
    );

    $(document).on('submit','form.add-cart',function(event){
        event.preventDefault();
        $.ajax({
            url: config.routes.cart,
            type : 'POST',
            dataType : 'json',
            data : $(this).serialize(),
            success : () => {
                this.parentNode.parentNode.remove();
            }
        })
    });

    $(document).on('submit','form.remove-cart',function(event){
        event.preventDefault();
        $.ajax({
            url: config.routes.cart,
            type : 'POST',
            dataType : 'json',
            data : $(this).serialize(),
            success : () => {
                this.parentNode.parentNode.remove();
            }
        })
    });

    $(document).on('submit','form#checkout',function(event){
        event.preventDefault();
        $.ajax({
            url: config.routes.orders,
            type : 'POST',
            dataType : 'json',
            data : $(this).serialize(),
            success : (response) => {
                window.location.hash = '#';
            },
            error : (xhr,status,error) => {
                renderErrors(xhr.responseJSON.errors);
            }
        })
    });

    $(document).on('submit','form#login',function(event){
        event.preventDefault();
        $.ajax({
            url: config.routes.login,
            type : 'POST',
            dataType : 'json',
            data : $(this).serialize(),
            success : (response) => {
                window.location.hash = '#products';
            },
            error : (xhr,status,error) => {
                renderErrors(xhr.responseJSON.errors);
                $('#password').val('');
            }
        })
    });

    $(document).on('submit','form#new_product',function(event){
        event.preventDefault();

        let fd = new FormData();
        let files = $('#file')[0].files[0];
        fd.append('file',files);

        $.ajax({
            url: config.routes.products,
            type : 'POST',
            dataType : 'json',
            data : $(this).serialize(),
            success : (response) => {
                alert('ceva2');
            },
            error : (xhr,status,error) => {
                alert('ceva');
                renderErrors(xhr.responseJSON.errors);
            }
        })
    });

    window.onhashchange = function () {
        $('.page').hide();

        $('#errors').html('');

        switch(window.location.hash) {
            case '#cart':
                $('.cart').show();
                $.ajax({
                    url: '/cart',
                    dataType: 'json',
                    success: function (response) {
                        $('.cart .list').html(renderListCart(response['data']));
                    }
                });
                break;
            case '#login':
                $('.login').show();
                break;
            case '#products':
                $('.products').show();
                $.ajax({
                    url: '/products',
                    dataType: 'json',
                    success: function (response) {
                        $('.cart .list').html(renderListCart(response['data']));
                    }
                });
                break;
            case '#products/create':
                $('.product_new').show();
                break;
            default:
                $('.index').show();
                $.ajax('/', {
                    dataType: 'json',
                    success: function (response) {
                        $('.index .list').html(renderListIndex(response['data']));
                    }
                });
                break;
        }
    }

    window.onhashchange();
})
