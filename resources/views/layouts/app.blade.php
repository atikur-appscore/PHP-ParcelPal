<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Parcel CMS</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="/assets/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="/assets/dist/css/skins/skin-blue.min.css">
    <link rel="stylesheet" href="/assets/dist/css/app.css">

    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>
<body id="app-layout" class="skin-blue sidebar-mini ng-scope">
    <div class="wrapper">
        <div class="content-wrapper">
            <section class="content">
                @yield('content')
            </section>
        </div>
    </div>

    <!-- JavaScripts -->
    <script src="/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
