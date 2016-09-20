<!DOCTYPE html>
<html ng-app="angularApp">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Parcel CMS</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/plugins/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="assets/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="assets/dist/css/skins/skin-blue.min.css">
    <link rel="stylesheet" href="assets/dist/css/loading.css">
    <link rel="stylesheet" href="assets/bower_components/AngularJS-Toaster/toaster.min.css"  />
    <link rel="stylesheet" href="assets/dist/css/app.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]
    
    <!-- jQuery 2.1.4 -->
    <script src="assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>

    <!-- DataTables -->
    <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/plugins/datatables/dataTables.bootstrap.min.js"></script>

    <!-- AdminLTE App -->
    <script src="assets/dist/js/app.js"></script>

    <script src="assets/bower_components/angular/angular.min.js"></script>
    <script src="assets/bower_components/angular-route/angular-route.min.js"></script>
    <script src="assets/bower_components/angular-animate/angular-animate.js"></script>
    <script src="assets/bower_components/angular-sanitize/angular-sanitize.js"></script>
    <script src="assets/bower_components/AngularJS-Toaster/toaster.min.js"></script>
    <script src="assets/bower_components/moment/moment.js"></script>
    <script src="assets/bower_components/underscore/underscore.js"></script>
    <script src="assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="assets/bower_components/bootbox.js/bootbox.js"></script>
    <script src="assets/bootstrap/ie10-viewport-bug-workaround.js"></script>
    <script src="assets/bootstrap/js/ui-bootstrap-tpls-1.3.2.min.js"></script>

    <!-- Angular Material Library -->
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.0/angular-aria.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.0/angular-messages.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/angular_material/1.0.0/angular-material.min.js"></script>

    <script src="assets/dist/js/common.js"></script>
    <script src="assets/dist/js/angular-app.js"></script>
    <script src="assets/dist/js/data.js"></script>

    <script src="assets/dist/js/services/data-service.js"></script>
    <script src="assets/dist/js/services/translate-service.js"></script>

    <script src="assets/dist/js/controllers/root-controller.js"></script>
    <script src="assets/dist/js/controllers/home-controller.js"></script>

    <script src="assets/dist/js/controllers/admin-controller.js"></script>
    <script src="assets/dist/js/controllers/admin-detail-controller.js"></script>
    
    <script src="assets/dist/js/controllers/user-controller.js"></script>
    <script src="assets/dist/js/controllers/user-detail-controller.js"></script>
    
    <script src="assets/dist/js/controllers/run-controller.js"></script>
    <script src="assets/dist/js/controllers/run-create-controller.js"></script>

    <script src="assets/dist/js/controllers/login-controller.js"></script>
    <script src="assets/dist/js/controllers/forgot-password-controller.js"></script>
    <script src="assets/dist/js/controllers/logout-controller.js"></script>
    
    <script type="application/javascript">
        var __csrf = "{{ csrf_token() }}";
    </script>

</head>

<body class="hold-transition skin-blue sidebar-mini" ng-controller="RootCtrl">
<!-- Loading Wrapper -->
<div id="loading" class="loading-layout" ng-show="isLoading">
    <div id="loading" class="loading_wrapper" ng-click="hideLoading()" title="Click to hide loading">
        <div class="windows8 loading_animation_wrapper">
            <div class="wBall" id="wBall_1">
                <div class="wInnerBall">
                </div>
            </div>
            <div class="wBall" id="wBall_2">
                <div class="wInnerBall">
                </div>
            </div>
            <div class="wBall" id="wBall_3">
                <div class="wInnerBall">
                </div>
            </div>
            <div class="wBall" id="wBall_4">
                <div class="wInnerBall">
                </div>
            </div>
            <div class="wBall" id="wBall_5">
                <div class="wInnerBall">
                </div>
            </div>
        </div>
        <div class="loading_text">Loading...</div>
    </div>
</div>

<!-- Layout Wrapper -->
<div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="#/home" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini">CMS</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg">Parcel CMS</span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="hidden-xs" ng-bind="auth.first_name"></span> <span class="hidden-xs" ng-bind="auth.last_name"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                <img class="img-circle" alt="User Image">
                            </li>
                            <!-- Menu Body -->
                            <li class="user-body">
                                <div class="col-xs-4 text-center">
                                    <a href="#">Followers</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">Sales</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">Friends</a>
                                </div>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="#" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <a href="#" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar Menu -->
            <ul class="sidebar-menu">
                <li><a href="#/home"><i class="fa fa-circle-o text-purple"></i> <span>Dashboard</span></a></li>
                <li><a href="#/admin"><i class="fa fa-circle-o text-green"></i> <span>Admins management</span></a></li>
                <li><a href="#/user"><i class="fa fa-circle-o text-green"></i> <span>Users management</span></a></li>
                <li><a href="#/runs"><i class="fa fa-circle-o text-green"></i> <span>Runs management</span></a></li> 
                <li><a href="#/logout"><i class="fa fa-circle-o text-black"></i> <span>Logout</span></a></li>
            </ul><!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div ng-view>
            </div>
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

</div><!-- ./wrapper -->


<toaster-container
        toaster-options="{'time-out': 3000, 'close-button': true, 'position-class': 'toast-bottom-center', 'limit': 3}">
</toaster-container>
</body>
</html>
