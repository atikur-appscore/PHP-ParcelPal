appControllers.controller('HomeCtrl', HomeController);
HomeController.$inject = ['$scope', '$rootScope', '$timeout', '$q', 'DataService', 'TranslateService', '$location', 'toaster'];

function HomeController($scope, $rootScope, $timeout, $q, DataService, TranslateService, $location, toaster) {
    
    $scope.api = 'statistic/dashboard';
    $scope.model = {};
    $scope.auth = $rootScope.auth;

    activate();

    function activate(){
        getStatistic();
    }

    function getStatistic() {
        $rootScope.showLoading();
        DataService.restGet($scope.api).then(function(response) {
            if(response && response.data){
                $scope.model = response.data
            }
        }, function(error) {
        }).finally(function() {
            $rootScope.hideLoading();
        });
    }
}