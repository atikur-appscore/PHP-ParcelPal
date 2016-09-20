
appControllers.controller('LoginCtrl', LoginController);
LoginController.$inject = ['$scope', '$rootScope', '$timeout', '$q', 'DataService', 'TranslateService', '$location', 'toaster'];

function LoginController($scope, $rootScope, $timeout, $q, DataService, TranslateService, $location, toaster) {
    
    $scope.api = 'user/login';
    $scope.model = {};
    
    $scope.login = login;

    activate();

    function activate(){
        console.log('LoginCtrl')
    }

    function login(){
        $rootScope.showLoading();
        $scope.model._token = __csrf;
        DataService.restPost($scope.api, $scope.model).then(function(response) {
            if(response && response.data) {
                $rootScope.auth = response.data;
                __setCookie('auth', JSON.stringify($rootScope.auth), 1);
                window.location = "#/home";
            }
        }, function(error) {
            DataService.toastLoginError();
            __deleteAllCookies();
        }).finally(function() {
            $rootScope.hideLoading();
        });
    }
}