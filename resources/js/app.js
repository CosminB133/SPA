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

    $('img').each(function () {
            $(this).attr('alt', trans($(this).attr('alt')));
        }
    );

    $('form#login').attr('action', config.routes.login);
    $('form#checkout').attr('action', config.routes.orders);
    $('form#new-product').attr('action', config.routes.products);
    $('form#review-post').attr('action', config.routes.reviews);

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
            });
        }
    );

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
            });
        }
    );

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
                    $('.alert').remove();

                    if ('errors' in xhr.responseJSON) {
                        errors = xhr.responseJSON.errors;
                        if ('name' in errors) {
                            renderError($('#name-cart'), errors.name)
                        }
                        if ('contact' in errors) {
                            renderError($('#contact-cart'), errors.contact)
                        }
                        if ('comments' in errors) {
                            renderError($('#comments-cart'), errors.comments)
                        }
                    }
                }
            });
        }
    );

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
                    $('.alert').remove();

                    if ('errors' in xhr.responseJSON) {
                        errors = xhr.responseJSON.errors;
                        if ('email' in errors) {
                            renderError($('#email-login'), errors.email);
                        }
                        if ('password' in errors) {
                            renderError($('#password-login'), errors.password);
                        }
                    }
                    $('#password-login').val('');
                }
            });
        }
    );

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
                    if (xhr.status === 401) {
                        window.location.hash = '#login';
                        return;
                    }
                }
            });
        }
    );

    $(document).on('submit', 'form#new-product', function (event) {
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
                    $('.alert').remove();
                    if (xhr.status === 401) {
                        window.location.hash = '#login';
                        return;
                    }
                    if ('errors' in xhr.responseJSON){
                        errors = xhr.responseJSON.errors;

                        if ('title' in errors) {
                            renderError($('#title-new-product'), errors.title);
                        }
                        if ('description' in errors) {
                            renderError($('#description-new-product'), errors.description);
                        }
                        if ('price' in errors) {
                            renderError($('#price-new-product'), errors.description);
                        }
                        if ('img' in errors) {
                            renderError($('#img-new-product'), errors.img);
                        }
                    }

                }
            });
        }
    );

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
                    $('.alert').remove();
                    if (xhr.status === 401) {
                        window.location.hash = '#login';
                        return;
                    }

                    if ('errors' in xhr.responseJSON) {
                        errors = xhr.responseJSON.errors;

                        if ('title' in errors) {
                            renderError($('#title-product-edit'), errors.title);
                        }
                        if ('description' in errors) {
                            renderError($('#description-product-edit'), errors.description);
                        }
                        if ('price' in errors) {
                            renderError($('#price-product-edit'), errors.description);
                        }
                        if ('img' in errors) {
                            renderError($('#img-product-edit'), errors.img);
                        }
                    }
                }
            });
        }
    );

    $(document).on('submit', 'form#review-post', function (event) {
            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                dataType: 'json',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: (response) => {
                    addReview($(this).serializeArray());
                },
                error: (xhr, status, error) => {
                    $('.alert').remove();

                    if ('errors' in xhr.responseJSON) {
                        errors = xhr.responseJSON.errors;
                        if ('rating' in errors) {
                            renderError($('#rating-review-post'), errors.title);
                        }
                        if ('description' in errors) {
                            renderError($('#comments-review-post'), errors.description);
                        }
                    }
                }
            });
        }
    );

    $(document).on('submit', 'form.review-delete', function (event) {
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
                    if (xhr.status === 401) {
                        window.location.hash = '#login';
                        return;
                    }
                }
            });
        }
    );

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
                    success: function (response) {
                        renderListCart(response.data);
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
                        renderListProducts(response.data);
                    },
                    error: (xhr, status, error) => {
                        if (xhr.status === 401) {
                            window.location.hash = '#login';
                        }
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
                        renderProductEdit(response.data);
                    },
                    error: (xhr, status, error) => {
                        if (xhr.status === 401) {
                            window.location.hash = '#login';
                        }
                    }
                });
                break;

            case hash === '#orders':
                $('.orders').show();

                $.ajax({
                    url: config.routes.orders,
                    dataType: 'json',
                    success: function (response) {
                        renderListOrders(response.data);
                    },
                    error: (xhr, status, error) => {
                        if (xhr.status === 401) {
                            window.location.hash = '#login';
                        }
                    }
                });

                break;

            case hash.match(/#orders\/[1-9]+[0-9]*/i) !== null:
                $('.order').show();

                let orderId = hash.match(/#orders\/([1-9]+[0-9]*)/i)[1];

                $.ajax({
                    url: config.routes.orders + '/' + orderId,
                    dataType: 'json',
                    success: function (response) {
                        console.log(response);
                        renderOrder(response.data);
                    },
                    error: (xhr, status, error) => {
                        console.log(xhr)
                        if (xhr.status === 401) {
                            window.location.hash = '#login';
                        }
                    }
                });

                break;

            case hash.match(/#products\/[1-9]+[0-9]*/i) !== null:
                $('.product-show').show();

                productId = hash.match(/#products\/([1-9]+[0-9]*)/i)[1];

                $.ajax({
                    url: config.routes.products + '/' + productId,
                    dataType: 'json',
                    success: function (response) {
                        renderProduct(response.data);
                    }
                });

                break;

            default:
                $('.index').show();

                $.ajax('/', {
                    dataType: 'json',
                    success: function (response) {
                        renderListIndex(response.data);
                    }
                });

                break;
        }
    }

    window.onhashchange();
})
