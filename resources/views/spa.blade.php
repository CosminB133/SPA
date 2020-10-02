<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>{{ config('app.name') }}</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script type="text/javascript">
        var config = {
            routes: {
                index: '{{ route('index') }}',
                cart: '{{ route('cart.index') }}',
                orders: '{{ route('orders.index') }}',
                login: '{{ route('login') }}',
                products: '{{ route('products.index') }}',
                reviews: '{{ route('reviews.store') }}',
            }
        };

        function __(text) {
            return text;
        }

        function renderError(element, error) {
            html = [
                '<div class="alert alert-danger">',
                error,
                '</div>',
            ].join('');

            element.closest('.form-group').after(html);
        }

        function renderListIndex(products) {
            html = '';

            $.each(products, function (key, product) {
                html += [
                    '<div class="row product" style="margin: 10px">',
                    '<div class="col-md-3">',
                    '<img src="/storage/img/' + product.id + '" alt="' + __('product image') + '" class="img-fluid" style="max-height: 150px; margin-right: 5px">',
                    '</div>',
                    '<div class="col-md-6">',
                    '<h4>' + product.title + '</h4>',
                    '<p>' + product.description + '</p>',
                    '<p>' + product.price + '</p>',
                    '</div>',
                    '<div class="col-md-3">',
                    '<form action="' + config.routes.cart + '" class="add-cart">',
                    '<input type="hidden" name="id" value="' + product.id + '">',
                    '<button class="btn btn-primary">' +  __('Add') + '</button>',
                    '<a href="#products/'+ product.id + '">' + __('Show') + '</a>',
                    '</form>',
                    '</div>',
                    '</div>',
                ].join('');
            });

            $('.index .list').html(html);
        }

        function renderListCart(products) {
            html = '';

            $.each(products, function (key, product) {
                html += [
                    '<div class="row product" style="margin: 10px">',
                    '<div class="col-md-3">',
                    '<img src="/storage/img/' + product.id + '" alt="' + __('product image') + '" class="img-fluid" style="max-height: 150px; margin-right: 5px">',
                    '</div>',
                    '<div class="col-md-6">',
                    '<h4>' + product.title + '</h4>',
                    '<p>' + product.description + '</p>',
                    '<p>' + product.price + '</p>',
                    '</div>',
                    '<div class="col-md-3">',
                    '<form action="' + config.routes.cart + '" class="remove-cart">',
                    '<input type="hidden" name="_method" value="DELETE">',
                    '<input type="hidden" name="id" value="' + product.id + '">',
                    '<button class="btn btn-danger">' + __('Remove') + '</button>',
                    '</form>',
                    '</div>',
                    '</div>',
                ].join('');
            });

            $('.cart .list').html(html);
        }

        function renderListProducts(products) {
            html = '';

            $.each(products, function (key, product) {
                html += [
                    '<div class="row" style="margin: 10px">',
                    '<div class="col-md-3">',
                    '<img src="/storage/img/' + product.id + '" alt="' + __('product image') + '" class="img-fluid" style="max-height: 150px; margin-right: 5px">',
                    '</div>',
                    '<div class="col-md-6">',
                    '<h4>' + product.title + '</h4>',
                    '<p>' + product.description + '</p>',
                    '<p>' + product.price + '</p>',
                    '</div>',
                    '<div class="col-md-3">',
                    '<a href="#products/' + product.id + '/edit" class="btn btn-primary">' + __('Edit') + '</a>',
                    '<form action="' + config.routes.products + '/'+ product.id + '" class="delete-product">',
                    '<input type="hidden" name="_method" value="DELETE">',
                    '<button class="btn btn-danger">' + __('Remove') + '</button>',
                    '</form>',
                    '</div>',
                    '</div>',
                ].join('');
            });

            $('.products .list').html(html);
        }

        function renderProductEdit(product) {
            $('#title-product-edit').attr('value', product.title);
            $('#description-product-edit').text(product.description);
            $('#price-product-edit').attr('value', product.price);
            $('form#product-edit').attr('action', config.routes.products + '/' + product.id);

            html = '';

            $.each(product.reviews, function (key, review) {
                html += [
                    '<div class="card">',
                    '<div class="card-body">',
                    '<h3>' + review.rating + '</h3>',
                    '<p>' + review.comments + '</p>',
                    '<form action="' + config.routes.reviews + '/' + review.id + '" class="review-delete">',
                    '<input type="hidden" name="_method" value="DELETE">',
                    '<button class="btn btn-danger">' + __('Delete') + '</button>',
                    '</form>',
                    '</div>',
                    '</div>',
                ].join('');
            });

            $('.product-edit .reviews').html(html);
        }

        function renderListOrders(orders) {
            html = '';

            $.each(orders, function (key, order) {
                html += [
                    '<div class="card" style="margin: 10px">',
                    '<h1 class="card-header">' + order.name + '</h1>',
                    '<div class="card-body">',
                    '<p>' + __('Contact details') + ':' + order.contact + '</p>',
                    '<p>' + __('Comments') + ':' + order.comments + '</p>',
                    '<p>'+ __('Order price:') + ':' + order.price + '</p>',
                    '<p>' + __('Made at') + ':'  + order.created_at + '</p>',
                    '<a href="#orders/' + order.id + '" class="btn btn-primary">' + __('Show') + '</a>',
                    '</div>',
                    '</div>',
                ].join('');
            });

            $('.orders .list').html(html);
        }

        function renderOrder(order) {
            $('#name-order').text(order.name);
            $('#contact-order').text(order.contact);
            $('#comments-order').text(order.comments);
            $('#price-order').text(order.price);
            $('#crated-order').text(order.created_at);

            html = '';

            $.each(order.products, function (key, product) {
                html += [
                    '<div class="row" style="margin: 10px">',
                    '<div class="col-md-3">',
                    '<img src="/storage/img/' + product.id + '" alt="' + __('product image') + '" class="img-fluid" style="max-height: 150px; margin-right: 5px">',
                    '</div>',
                    '<div class="col-md-9">',
                    '<h4>' + product.title + '</h4>',
                    '<p>' + product.description + '</p>',
                    '<p>' + product.price + '</p>',
                    '</div>',
                    '</div>',
                ].join('');
            });

            $('.order .list').html(html);
        }

        function renderProduct(product) {
            $('#product-show-img').attr('src', '/storage/img/' + product.id);
            $('#product-show-title').text(product.title);
            $('#product-show-description').text(product.description);
            $('#product-show-price').text(product.price);

            $('#review-post-product-id').attr('value', product.id);

            html = '';

            $.each(product.reviews, function (key, review) {
                html += [
                    '<div class="card">',
                    '<div class="card-body">',
                    '<h3>' + review.rating + '</h3>',
                    '<p>' + review.comments + '</p>',
                    '</div>',
                    '</div>',
                ].join('');
            });

            $('.product-show .reviews').html(html);
        }

        function addReview(review) {
            html = [
                '<div class="card">',
                '<div class="card-body">',
                '<h3>' + review[0].value + '</h3>',
                '<p>' + review[1].value + '</p>',
                '</div>',
                '</div>',
            ].join('');

            $('.product-show .reviews').prepend(html);
        }

    </script>

    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body>

<div class="container">

    <div id="errors"></div>

    <div class="page index">
        <div class="list"></div>
        <a href="#cart" class="btn btn-primary" data-translate>Go to cart</a>
    </div>

    <div class="page cart">
        <div class="list"></div>
        <form id="checkout">
            <div class="form-group">
                <label for="name-cart" data-translate>Name</label>
                <input type="text" class="form-control" name="name" id="name-cart">
            </div>

            <div class="form-group">
                <label for="contact-cart" data-translate>Contact details :</label>
                <input type="text" class="form-control" name="contact" id="contact-cart">
            </div>

            <div class="form-group">
                <label for="comments-cart" data-translate>Comments :</label>
                <input type="text" class="form-control" name="comments" id="comments-cart">
            </div>

            <button class="btn btn-success" data-translate>Submit</button>
        </form>
        <a href="#" class="btn btn-primary" data-translate>Go to index</a>
    </div>

    <div class="page login">
        <form id="login">
            <div class="form-group">
                <label for="email-login">Email</label>
                <input id="email-login" type="email" class="form-control" name="email">
            </div>

            <div class="form-group">
                <label for="password-login">Password</label>
                <input id="password-login" type="password" class="form-control" name="password">
            </div>

            <div class="form-group">
                <input class="form-check-input" type="checkbox" name="remember" id="remember-login">
                <label class="form-check-label" for="remember-login" data-translate>
                    Remember Me
                </label>
            </div>
            <button class="btn btn-primary" data-translate>Login</button>
        </form>
    </div>

    <div class="page products">
        <div class="list"></div>
        <a href="#products/create" class="btn btn-primary" data-translate>New</a>
    </div>

    <div class="page new-product">
        <div class="list"></div>
        <h1 data-translate>Add Product</h1>
        <form id="new-product">

            <div class="form-group">
                <label for="title" data-translate> Title : </label>
                <input type="text" name="title" id="title-new-product" class="form-control">
            </div>

            <div class="form-group">
                <label for="description-new-product" data-translate> Description : </label>
                <textarea name="description" id="description-new-product" cols="30" rows="10" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label for="price-new-product"  data-translate> Price : </label>
                <input type="text" name="price" id="price-new-product" class="form-control">
            </div>

            <div class="form-group">
                <label for="img-new-product" data-translate> Image : </label>
                <input type="file" name="img" id="img-new-product" class="form-control-file" >
            </div>

            <button class="btn btn-primary" data-translate>Create</button>
        </form>
    </div>

    <div class="page product-edit">
        <h1 data-translate>Edit Product</h1>
        <form id="product-edit" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="PATCH">
            <div class="form-group">
                <label for="title-product-edit">Title</label>
                <input type="text" name="title" id="title-product-edit" class="form-control">
            </div>
            <div class="form-group">
                <label for="description-product-edit">Description</label>
                <textarea name="description" id="description-product-edit" cols="30" rows="10" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label for="price-product-edit"></label>
                <input type="text" name="price" id="price-product-edit" class="form-control">
            </div>
            <div class="form-group">
                <label for="img-product-edit" data-translate>Image</label>
                <input type="file" name="img" id="img-product-edit" class="form-control-file">
            </div>

            <button class="btn btn-primary" data-translate>Update</button>
        </form>
        <div class="reviews"></div>
    </div>

    <div class="page orders">
        <div class="list"></div>
    </div>

    <div class="page order">
        <div class="card">
            <h1 class="card-header" id="name-order"></h1>
            <div class="card-body">
                <p data-translate>Contact details :</p>
                <p id="contact-order"></p>

                <p data-translate>Comments:</p>
                <p id="comments-order"></p>

                <p data-translate>Order price:</p>
                <p id="price-order"></p>

                <p data-translate>Made at: </p>
                <p id="crated-order"></p>
            </div>
        </div>

        <div class="list"></div>
    </div>

    <div class="page product-show">

        <div class="row" style="margin: 10px">
            <div class="col-md-3">
                <img id="product-show-img" alt="product image" class="img-fluid"
                     style="max-height: 150px; margin-right: 5px">
            </div>
            <div class="col-md-9">
                <h4 id="product-show-title"></h4>
                <p id="product-show-description"></p>
                <p id="product-show-price"></p>
            </div>
        </div>

        <form id="review-post">
            <div class="form-group">
                <label for="rating-review-post" data-translate>Rating</label>
                <select name="rating" id="rating-review-post">
                    <option value="1" data-translate>1</option>
                    <option value="2" data-translate>2</option>
                    <option value="3" data-translate>3</option>
                    <option value="4" data-translate>4</option>
                    <option value="5" data-translate>5</option>
                </select>
            </div>
            <div class="form-group">
                <label for="comments-review-post" data-translate>Comments</label>
                <textarea name="comments" id="comments-review-post" cols="30" rows="10" class="form-control"></textarea>
            </div>
            <input type="hidden" name="product_id" id="review-post-product-id">

            <button class="btn btn-success" data-translate>Submit</button>
        </form>

        <div class="reviews"></div>
    </div>

</div>
</body>
</html>
