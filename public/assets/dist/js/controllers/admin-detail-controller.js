
appControllers.controller('AdminDetailCtrl', AdminDetailController);

AdminDetailController.$inject = ['$scope', '$rootScope', '$timeout', '$q', 'DataService', 'TranslateService', '$location', 'toaster'];

function AdminDetailController($scope, $rootScope, $timeout, $q, DataService, TranslateService, $location, toaster) {
    
    $scope.api = "admin";
    $scope.action = null;
    $scope.actionID = null;
    $scope.model = {};

    $scope.save = save;

    activate();

    function activate() {
        var id = __getParameterByName("id");
        if (id && !isNaN(id)){
            $scope.action = "Update";
            $scope.actionID = parseInt(id);
            loadDetail(id);
        } else {
            $scope.action = "Create";
            $scope.actionID = null;
        }
    }

    function loadDetail(id) {
        var url = "{0}/{1}".format($scope.api, id);
        DataService.restGet(url).then(function(response){
            if(response && response.data) {
                $scope.model = response.data;
            }
        }, function(error) {
            DataService.toastCommonError();
            $timeout(function() {
                window.location = "#/" + $scope.api;
            }, 250);
        })
    }

    function save() {
        if($scope.actionID) {
            update($scope.actionID, $scope.model);
        } else {
            insert($scope.model);
        }
    }

    function update(id, model) {
        var url = "{0}/{1}".format($scope.api, id);
        DataService.restPut(url, model).then(function(response) {
            DataService.toastInsertSuccess();
            
            $timeout(function() {
                window.location = "#/" + $scope.api;
            }, 250);

        }, function(error) {
            DataService.toastCommonError(error);
        });
    }

    function insert(model) {
        DataService.restPost($scope.api, model).then(function(response) {
            DataService.toastInsertSuccess();
            $scope.model = null;

            $timeout(function() {
                window.location = "#/" + $scope.api;
            }, 250);

        }, function(error) {
            DataService.toastCommonError(error);
        });
    }
}
