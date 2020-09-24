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
                cart: '{{ route('cart') }}',
                orders: '{{ route('orders') }}',
                login: '{{ route('login') }}',
                products: '{{ route('products') }}',
            }
        };

        function trans(text) {
            return text;
        }

        function renderErrors(errors) {
            html = '';

            $.each(errors, function (key, error) {
                console.log(error[0])
                html += [
                    '<div class="alert alert-danger">',
                    error,
                    '</div>',
                ].join('');
            });

            $('#errors').html(html);
        }

        function renderListIndex(products) {
            html = '';

            $.each(products, function (key, product) {
                html += [
                    '<div class="row" style="margin: 10px">',
                    '<div class="col-md-3">',
                    '<img src="/img/' + product.id + '" alt="' + trans('product image') + '" class="img-fluid" style="max-height: 150px; margin-right: 5px">',
                    '</div>',
                    '<div class="col-md-6">',
                    '<h4>' + product.title + '</h4>',
                    '<p>' + product.description + '</p>',
                    '<p>' + product.price + '</p>',
                    '</div>',
                    '<div class="col-md-3">',
                    '<form action="' + config.routes.cart + '" class="add-cart">',
                    '<input type="hidden" name="id" value="' + product.id + '">',
                    '<input type="submit" class="btn btn-danger" value="' + trans('Add') + '">',
                    '</form>',
                    '</div>',
                    '</div>',
                ].join('');
            });

            return html;
        }

        function renderListCart(products) {
            html = '';

            $.each(products, function (key, product) {
                html += [
                    '<div class="row" style="margin: 10px">',
                    '<div class="col-md-3">',
                    '<img src="/img/' + product.id + '" alt="' + trans('product image') + '" class="img-fluid" style="max-height: 150px; margin-right: 5px">',
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
                    '<input type="submit" class="btn btn-danger" value="' + trans('Remove') + '">',
                    '</form>',
                    '</div>',
                    '</div>',
                ].join('');
            });

            return html;
        }

        function renderListProducts(products) {
            html = '';

            $.each(products, function (key, product) {
                html += [
                    '<div class="row" style="margin: 10px">',
                    '<div class="col-md-3">',
                    '<img src="/img/' + product.id + '" alt="' + trans('product image') + '" class="img-fluid" style="max-height: 150px; margin-right: 5px">',
                    '</div>',
                    '<div class="col-md-6">',
                    '<h4>' + product.title + '</h4>',
                    '<p>' + product.description + '</p>',
                    '<p>' + product.price + '</p>',
                    '</div>',
                    '<div class="col-md-3">',
                    '<a href="#products/' + product.id + '/edit" class="btn btn-primary">' + trans('Edit') + '</a>',
                    '<form action="' + config.routes.products + '/'+ product.id + '" class="delete-product">',
                    '<input type="hidden" name="_method" value="DELETE">',
                    '<input type="submit" class="btn btn-danger" value="' + trans('Delete') + '">',
                    '</form>',
                    '</div>',
                    '</div>',
                ].join('');
            });

            return html;
        }

        function renderProductEdit(product) {
            $('#title-product-edit').attr('value', product.title);
            $('#description-product-edit').text(product.description);
            $('#price-product-edit').attr('value', product.price);
            $('form#product-edit').attr('action', config.routes.products + '/' + product.id);
        }

        function renderListOrders(orders) {
            html = '';

            $.each(orders, function (key, order) {
                html += [
                    '<div class="card" style="margin: 10px">',
                    '<h1 class="card-header">' + order.name + '</h1>',
                    '<div class="card-body">',
                    '<p>' + trans('Contact details') + ':' + order.contact + '</p>',
                    '<p>' + trans('Comments') + ':' + order.comments + '</p>',
                    '<p>'+ trans('Order price:') + ':' + order.price + '</p>',
                    '<p>' + trans('Made at') + ':'  + order.created_at + '</p>',
                    '<a href="#orders/' + order.id + '" class="btn btn-primary">' + trans('Show') + '</a>',
                    '</div>',
                    '</div>',
                ].join('');
            });

            return html;
        }

        function renderOrder(order) {
            console.log(order)
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
                    '<img src="/img/' + product.id + '" alt="' + trans('product image') + '" class="img-fluid" style="max-height: 150px; margin-right: 5px">',
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

    </script>

    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body>

<div class="container">

    <div id="errors"></div>

    <div class="page index">
        <div class="list"></div>
        <a href="#cart" class="btn btn-primary">Go to cart</a>
    </div>

    <div class="page cart">
        <div class="list"></div>
        <form id="checkout">
            <div class="form-group">
                <label for="name" data-translate>Name</label>
                <input type="text" class="form-control" name="name" id="name">
            </div>
            <div class="form-group">
                <label for="contact" data-translate>Contact details :</label>
                <input type="text" class="form-control" name="contact" id="contact">
            </div>
            <div class="form-group">
                <label for="comments" data-translate>Comments :</label>
                <input type="text" class="form-control" name="comments" id="comments">
            </div>
            <input type="submit" class="btn btn-success" value="Submit">
        </form>
        <a href="#" class="button" data-translate>Go to index</a>
    </div>

    <div class="page login">
        <form id="login">
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" class="form-control" name="email">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" class="form-control" name="password">
            </div>

            <div class="form-group">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label" for="remember" data-translate>
                    Remember Me
                </label>
            </div>
            <input type="submit" class="btn btn-primary" value="Login">
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
                <label for="description-new-product" data-translate> Description </label>
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

            <input type="submit" class="btn btn-primary" value="Create">
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
            <input type="submit" class="btn btn-primary" value="Update">
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

</div>
</body>
</html>
