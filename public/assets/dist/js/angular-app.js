'use strict';

/* App Module */
var angularApp = angular.module('angularApp', [
    'ngRoute',
    'ngAnimate',
    'toaster',
    'ui.bootstrap',
    'appControllers',
    'ngMaterial',
    'ngSanitize'
]);

// Routing
angularApp.config(['$routeProvider',
    function($routeProvider) {
        $routeProvider
            .when('/home', {
                templateUrl: '/assets/dist/views/home.html',
                controller: 'HomeCtrl'
            })
            .when('/login', {
                templateUrl: '/assets/dist/views/login.html',
                controller: 'LoginCtrl'
            })
            .when('/forgot-password', {
                templateUrl: '/assets/dist/views/forgot-password.html',
                controller: 'ForgotPasswordCtrl'
            })
            .when('/logout', {
                templateUrl: '/assets/dist/views/logout.html',
                controller: 'LogoutCtrl'
            })
            .when('/admin', {
                templateUrl: '/assets/dist/views/admin.html',
                controller: 'AdminCtrl'
            })
            .when('/admin/detail', {
                templateUrl: '/assets/dist/views/admin-detail.html',
                controller: 'AdminDetailCtrl'
            })
            .when('/user', {
                templateUrl: '/assets/dist/views/user.html',
                controller: 'UserCtrl'
            })
            .when('/user/detail', {
                templateUrl: '/assets/dist/views/user-detail.html',
                controller: 'UserDetailCtrl'
            })
            .when('/runs', {
                templateUrl: 'assets/dist/views/run.html',
                controller: 'RunCtrl'
            })
            .when('/runs/detail', {
                templateUrl: 'assets/dist/views/run-detail.html',
                controller: 'RunCreateCtrl'
            })
            .otherwise({
                redirectTo: '/home'
            });


    }]);

angularApp.config(function($mdDateLocaleProvider) {
    $mdDateLocaleProvider.formatDate = function(date) {
        return moment(date).format('DD-MM-YYYY');
    };
});

var appControllers = angular.module('appControllers', []);

angularApp.run(['$rootScope', '$location', 'DataService', function ($rootScope, $location, DataService) {
    $rootScope.$on('$locationChangeStart', function (event, next, current) {
        var auth = __getCookie('auth');
        try {
            auth = JSON.parse(auth);
        }catch(error){
            auth = null;
        }
        if (auth){
            $rootScope.auth = auth;
        }
        else if (next.indexOf("#/forgot-password") > -1){
            // Guest can access forgot password page
        }
        else {
            // Ensure clear cookie
            console.log("Not login. Cannot go to other pages");
            $rootScope.goToLogin();
            if (next.indexOf("#/login") == -1)
                event.preventDefault();

        }
    });
}]);

angularApp.directive('keyEnter', function () {
    return function (scope, element, attrs) {
        element.bind("keyup", function (event) {
            if(event.which === 13) {
                scope.$apply(function (){
                    scope.$eval(attrs.keyEnter);
                });

                event.preventDefault();
            }
        });
    };
});
