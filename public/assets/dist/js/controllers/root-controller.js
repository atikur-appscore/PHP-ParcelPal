appControllers.controller('RootCtrl', RootController);
RootController.$inject = ['$rootScope', '$timeout', '$q', 'DataService', 'TranslateService', '$location', 'toaster'];
function RootController($rootScope, $timeout, $q, DataService, TranslateService, $location, toaster) {
    
    $rootScope.hideLoading = hideLoading;
    $rootScope.showLoading = showLoading;
    $rootScope.logout = logout;
    $rootScope.goToLogin = goToLogin;

    activate();

    function activate(){
        console.log('RootCtrl')
    }

    function hideLoading(){
        $rootScope.isLoading = false;
    }

    function showLoading(){
        $rootScope.isLoading = true;
    }

    function logout() {
        console.log("Logout");
        __deleteAllCookies();
        $rootScope.auth = null;
        $rootScope.isLogged = false;
    }

    function goToLogin() {
        $rootScope.logout();
        window.location = "#/login";
    }
}