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

    $('form#login').attr('action', config.routes.login);
    $('form#checkout').attr('action', config.routes.orders);
    $('form#new-product').attr('action', config.routes.products);

    $(document).on('submit', 'form.add-cart', function (event) {
        event.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'json',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: () => {
                this.parentNode.parentNode.remove();
            }
        })
    });

    $(document).on('submit', 'form.remove-cart', function (event) {
        event.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'json',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: () => {
                this.parentNode.parentNode.remove();
            }
        })
    });

    $(document).on('submit', 'form#checkout', function (event) {
        event.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'json',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: (response) => {
                window.location.hash = '#';
            },
            error: (xhr, status, error) => {
                renderErrors(xhr.responseJSON.errors);
            }
        })
    });

    $(document).on('submit', 'form#login', function (event) {
        event.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'json',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: (response) => {
                window.location.hash = '#products';
            },
            error: (xhr, status, error) => {
                renderErrors(xhr.responseJSON.errors);
                $('#password').val('');
            }
        })
    });

    $(document).on('submit', 'form.delete-product', function (event) {
        event.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'json',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: (response) => {
                this.parentNode.parentNode.remove();
            },
            error: (xhr, status, error) => {
                renderErrors(xhr.responseJSON.errors);
            }
        })
    });

    $(document).on('submit', 'form#product-new', function (event) {
        event.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'json',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: (response) => {
                window.location.hash = '#products';
            },
            error: (xhr, status, error) => {
                renderErrors(xhr.responseJSON.errors);
            }
        })
    });

    $(document).on('submit', 'form#product-edit', function (event) {
        event.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'json',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: (response) => {
                window.location.hash = '#products';
            },
            error: (xhr, status, error) => {
                renderErrors(xhr.responseJSON.errors);
            }
        })
    });

    window.onhashchange = function () {
        $('.page').hide();

        $('#errors').html('');

        hash = window.location.hash;

        switch (true) {
            case hash === '#cart':
                $('.cart').show();
                $.ajax({
                    url: config.routes.cart,
                    dataType: 'json',
                    success: function (response) {
                        $('.cart .list').html(renderListCart(response.data));
                    }
                });
                break;
            case hash === '#login':
                $('.login').show();
                break;
            case hash === '#products':
                $('.products').show();
                $.ajax({
                    url: config.routes.products,
                    dataType: 'json',
                    success: function (response) {
                        $('.products .list').html(renderListProducts(response.data));
                    }
                });
                break;
            case hash === '#products/create':
                $('.new-product').show();
                break;
            case hash.match(/#products\/[1-9]+[0-9]*\/edit/i) !== null :
                $('.product-edit').show();

                productId = hash.match(/#products\/([1-9]+[0-9]*)\/edit/i)[1];

                $.ajax({
                    url: config.routes.products + '/' + productId + '/edit',
                    dataType: 'json',
                    success: function (response) {
                        $('.product-edit').html(renderProductEdit(response.data));
                    }
                });
                break;
            case hash === '#orders':
                $('.orders').show();
                $.ajax({
                    url: config.routes.orders,
                    dataType: 'json',
                    success: function (response) {
                        $('.orders .list').html(renderListOrders(response.data));
                    }
                });
                break;
            case hash.match(/#orders\/[1-9]+[0-9]*/i) !== null:
                $('.order').show();

                orderId = hash.match(/#orders\/([1-9]+[0-9]*)/i)[1];

                $.ajax({
                    url: config.routes.orders + '/' + orderId,
                    dataType: 'json',
                    success: function (response) {
                        console.log(response);
                        renderOrder(response.data);
                    }
                });
                break;
            default:
                $('.index').show();
                $.ajax('/', {
                    dataType: 'json',
                    success: function (response) {
                        $('.index .list').html(renderListIndex(response.data));
                    }
                });
                break;
        }
    }

    window.onhashchange();
})
