
appControllers.controller('UserDetailCtrl', UserDetailController);
UserDetailController.$inject = ['$scope', '$rootScope', '$timeout', '$q', 'DataService', 'TranslateService', '$location', 'toaster'];

function UserDetailController($scope, $rootScope, $timeout, $q, DataService, TranslateService, $location, toaster) {
    
    $scope.api = "user";
    $scope.action = null;
    $scope.actionID = null;
    $scope.model = {};
    $scope.isEdit = false;
    $scope.activeTab = 1;
    $scope.dateOptions = {
        dateDisabled: false,
        formatYear: 'yyyy',
        maxDate: new Date(),
        minDate: new Date(1900, 1, 1),
        startingDay: 1
    };
    
    $scope.popup = {
        opened: false
    };

    $scope.open = function() {
        $scope.popup.opened = true;
    };

    $scope.translate = TranslateService;

    $scope.save = save;
    $scope.switchMode = switchMode;
    $scope.switchTab = switchTab;

    activate();

    function activate() {
        console.log('UserDetailCtrl');
        var id = __getParameterByName("id");
        if (id && !isNaN(id)) {
            $scope.action = "Update";
            $scope.actionID = parseInt(id);
            $scope.isEdit = false;
            loadDetail(id);
        } else {
            $scope.action = "Add";
            $scope.actionID = null;
            $scope.model.gender_id = 1;
        }
    }

    function loadDetail(id) {
        var url = "{0}/{1}".format($scope.api, id);
        DataService.restGet(url).then(function(response) {
            if(response && response.data) {
                $scope.model = response.data;
                if ($scope.model.dob)
                    $scope.model.dob = new Date($scope.model.dob);
                $scope.model.total_photo = 6;
                $scope.model.total_video = 5;
                $scope.model.total_interest = 12;
                $scope.model.description = "Some description";
            }
        }, function(error) {
            DataService.toastCommonError();
            $timeout(function() {
                window.location = "#/" + $scope.api;
            },250);
        })
    }

    function save() {
        if($scope.actionID) {
            update($scope.actionID, $scope.model);
        }else{
            insert($scope.model);
        }
    }

    function update(id, model) {
        var url = "{0}/{1}".format($scope.api, id);
        DataService.restPut(url, model).then(function(response) {
            DataService.toastUpdateSuccess();
            $timeout(function() {
                window.location = "#/" + $scope.api;
            }, 250);
        }, function(error) {
            DataService.toastCommonError(error);
        })
    }

    function insert(model) {
        DataService.restPost($scope.api, model).then(function(response){
            DataService.toastInsertSuccess();
            // $scope.model = null;
            $timeout(function() {
                window.location = "#/" + $scope.api;
            }, 250);
        }, function(error) {
            DataService.toastCommonError(error);
        })
    }

    function switchMode() {
        $scope.isEdit = !$scope.isEdit;
    }

    function switchTab(tabID) {
        $scope.activeTab = tabID;
    }
}