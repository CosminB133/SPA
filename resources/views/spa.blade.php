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

            html = [
                '<h1 data-translate>' + trans('Edit Product') + '</h1>',
                '<form action="" method="post" enctype="multipart/form-data">',
                '<input type="hidden" name="_method" value="PATCH">',
                '<div class="form-group">',
                '<label for="title">' + trans('Title') + '</label>',
                '<input type="text" name="title" id="title" class="form-control" value="' + product.title + '">',
                '</div>',
                '<div class="form-group">',
                '<label for="description">' + trans('Description')  + '</label>',
                '<textarea name="description" id="description" cols="30" rows="10" class="form-control">' +  product.description + '</textarea>',
                '</div>',
                '<div class="form-group">',
                '<label for="price">' + trans('Price')  + '</label>',
                '<input type="text" name="price" id="price" class="form-control" value="' + product.price + '">',
                '</div>',
                '<div class="form-group">',
                '<label for="img">' + trans('Image') + '</label>',
                '<input type="file" name="img" id="img" class="form-control-file">',
                '</div>',
                '<input type="submit" class="btn btn-primary" value="' + trans('Submit') + '">',
                '</form>',
                '<div class="reviews"></div>',
        ].join('');

            return html;
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
        <a href="#products/create" class="btn btn-primary">{{ __('New') }}</a>
    </div>

    <div class="page product_new">
        <div class="list"></div>
        <h1 data-translate>Add Product</h1>
        <form id="new-product">
            <div class="form-group">
                <label for="title" data-translate> Title : </label>
                <input type="text" name="title" id="title" class="form-control">
            </div>
            <div class="form-group">
                <label for="description" data-translate> Description </label>
                <textarea name="description" id="" cols="30" rows="10" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label for="price"  data-translate> Price : </label>
                <input type="text" name="price" id="price" class="form-control">
            </div>

            <div class="form-group">
                <label for="img" data-translate> Image : </label>
                <input type="file" name="img" id="img" class="form-control-file" >
            </div>

            <input type="submit" class="btn btn-primary" value="Create">
        </form>
    </div>
    <div class="page product-edit">

    </div>

</div>
</body>
</html>
