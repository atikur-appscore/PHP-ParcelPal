
appControllers.controller('ForgotPasswordCtrl', ForgotPasswordController);
ForgotPasswordController.$inject = ['$scope', '$rootScope', '$timeout', '$q', 'DataService', 'TranslateService', '$location', 'toaster'];

function ForgotPasswordController($scope, $rootScope, $timeout, $q, DataService, TranslateService, $location, toaster) {
    
    $scope.api = "user/reset_password" ;
    $scope.model = {};

    $scope.resetPassword = resetPassword;

    activate();

    function activate() {
        console.log('ForgotPasswordCtrl')
    }

    function resetPassword() {
        $rootScope.showLoading();
        $scope.model._token = __csrf;
        DataService.restPost($scope.api, $scope.model).then(function(response) {
            DataService.toastResetPasswordSuccess();
        }, function(error) {
            DataService.toastResetPasswordError();
        }).finally(function() {
            $rootScope.hideLoading();
        });
    }
}