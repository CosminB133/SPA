require('./bootstrap');

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {

    $('[data-translate]').each(function () {
        $(this).text(__($(this).text()));
    });

    $('img').each(function () {
        $(this).attr('alt', __($(this).attr('alt')));
    });

    $('form#login').attr('action', config.routes.login);
    $('form#checkout').attr('action', config.routes.orders);
    $('form#new-product').attr('action', config.routes.products);
    $('form#review-post').attr('action', config.routes.reviews);

    $(document).ajaxError(function (event, xhr, settings) {
        if (xhr.status === 401) {
            window.location.hash = '#login';
            return;
        }

        if ('errors' in xhr.responseJSON) {
            errors = xhr.responseJSON.errors;
            $.each(errors, function (key, error) {
                renderError($('[name="' + key + '"]'), error);
            });
        }
    });

    $(document).on('submit', 'form.add-cart', function (event) {
        event.preventDefault();
        $('.alert').remove();

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'json',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: () => this.closest('.product').remove()
        });
    });

    $(document).on('submit', 'form.remove-cart', function (event) {
        event.preventDefault();
        $('.alert').remove();

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'json',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: () => this.closest('.product').remove()
        });
    });

    $(document).on('submit', 'form#checkout', function (event) {
        event.preventDefault();
        $('.alert').remove();

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'json',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: () => window.location.hash = '#'
        });
    });

    $(document).on('submit', 'form#login', function (event) {
        event.preventDefault();
        $('.alert').remove();

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'json',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: () => window.location.hash = '#products'

        });
    });

    $(document).on('submit', 'form.delete-product', function (event) {
        event.preventDefault();
        $('.alert').remove();

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'json',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: () => this.parentNode.parentNode.remove()

        });
    });

    $(document).on('submit', 'form#new-product', function (event) {
        event.preventDefault();
        $('.alert').remove();

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'json',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: () => window.location.hash = '#products'
        });
    });

    $(document).on('submit', 'form#product-edit', function (event) {
        event.preventDefault();
        $('.alert').remove();

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'json',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: () => window.location.hash = '#products',
        });
    });

    $(document).on('submit', 'form#review-post', function (event) {
        event.preventDefault();
        $('.alert').remove();

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'json',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: () => addReview($(this).serializeArray())
        });
    });

    $(document).on('submit', 'form.review-delete', function (event) {
        event.preventDefault();
        $('.alert').remove();

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'json',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: () => this.parentNode.parentNode.remove()
        });
    });

    window.onhashchange = function () {
        $('.page').hide();
        $('.alert').remove();

        hash = window.location.hash;

        switch (true) {
            case hash === '#cart':
                $('.cart').show();

                $.ajax({
                    url: config.routes.cart,
                    dataType: 'json',
                    success: (response) => renderListCart(response.data)
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
                    success: (response) => renderListProducts(response.data)
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
                    success: (response) => renderProductEdit(response.data)
                });
                break;

            case hash === '#orders':
                $('.orders').show();

                $.ajax({
                    url: config.routes.orders,
                    dataType: 'json',
                    success: (response) => renderListOrders(response.data)
                });
                break;

            case hash.match(/#orders\/[1-9]+[0-9]*/i) !== null:
                $('.order').show();

                let orderId = hash.match(/#orders\/([1-9]+[0-9]*)/i)[1];

                $.ajax({
                    url: config.routes.orders + '/' + orderId,
                    dataType: 'json',
                    success: (response) => renderOrder(response.data)
                });
                break;

            case hash.match(/#products\/[1-9]+[0-9]*/i) !== null:
                $('.product-show').show();

                productId = hash.match(/#products\/([1-9]+[0-9]*)/i)[1];

                $.ajax({
                    url: config.routes.products + '/' + productId,
                    dataType: 'json',
                    success: (response) => renderProduct(response.data)
                });
                break;

            default:
                $('.index').show();

                $.ajax({
                    url: config.routes.index,
                    dataType: 'json',
                    success: (response) => renderListIndex(response.data)
                });
                break;
        }
    }

    window.onhashchange();
})
