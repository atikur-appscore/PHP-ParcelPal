
appControllers.controller('RunCreateCtrl', RunCreateController);
RunCreateController.$inject = ['$scope', '$rootScope', '$timeout', '$q', 'DataService', 'TranslateService', '$location', 'toaster'];

function RunCreateController($scope, $rootScope, $timeout, $q, DataService, TranslateService, $location, toaster) {
    
    $scope.api = "runs";
    $scope.action = null;
    $scope.actionID = null;
    $scope.model = {};
    $scope.parcels = {};
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

    function loadDetail(id)
    {
        var url = "{0}/{1}".format($scope.api, id);
        var urlParcel = '/parcels?run_id='+ id;

        DataService.restGet(url).then(function(response) {
            if(response && response.data) {
                $scope.model = response.data;
                $scope.table = $("#parcel-table").DataTable({
                    "ajax": urlParcel,
                    "columns": [
                        { "data": "recipient_name" },
                        { "data": "weight" },
                        { "data": "address" },
                        { "data": "delivered" },
                    ],
                    "paging": true,
                    "lengthChange": false,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "columnDefs": [
                        {
                            "targets": 2,
                            "render": renderColumnAddress,
                            "sortable": true
                        },
                        {
                            "targets": 3,
                            "render": renderColumnDelivered,
                            "sortable": true
                        }
                    ]
                });
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
            DataService.toastCommonError();
        })
    }

    function insert(model) {
        DataService.restPost($scope.api, model).then(function(response){
            DataService.toastInsertSuccess();
            $timeout(function() {
                window.location = "#/" + $scope.api;
            }, 250);
        }, function(error) {
            DataService.toastCommonError();
        })
    }

    function switchMode() {
        $scope.isEdit = !$scope.isEdit;
    }

    function switchTab(tabID) {
        $scope.activeTab = tabID;
    }

    function renderColumnDelivered (data){
        if (data == 1){
            return "Delivered";
        }else{
            return "Undelivered";
        }
    }

    function renderColumnAddress (data){
        return (data.unit_number) ?  data.unit_number + '/' + data.street_number + ' ' + data.street_name + ', ' + data.suburb + ', ' + data.state :
            data.street_number + ' ' + data.street_name + ', ' + data.suburb + ', ' + data.state;
    }
}