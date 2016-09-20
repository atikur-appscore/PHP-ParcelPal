
appControllers.controller('LogoutCtrl', LogoutController);
LogoutController.$inject = ['$scope', '$rootScope', '$timeout', '$q', 'DataService', 'TranslateService', '$location', 'toaster'];

function LogoutController($scope, $rootScope, $timeout, $q, DataService, TranslateService, $location, toaster) {
    
    activate();

    function activate() {
        console.log('LogoutCtrl');
        $rootScope.goToLogin();
    }
}