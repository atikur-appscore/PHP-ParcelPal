
appControllers.controller('RunCtrl', RunController);
RunController.$inject = ['$scope', '$rootScope', '$timeout', '$q', 'DataService', 'TranslateService', '$location', 'toaster'];

function RunController($scope, $rootScope, $timeout, $q, DataService, TranslateService, $location, toaster) {
    
    $scope.api = "runs";
    $scope.tableID = "runs-table";
    $scope.keyword = "";
    $scope.table = null;

    $scope.refresh = refresh;
    $scope.search = search;
    $scope.add = add;

    activate();

    function activate() {
        $scope.refresh();
    }

    function refresh() {
        $scope.table = $("#" + $scope.tableID).DataTable({
            "ajax": $scope.api,
            "columns": [
                { "data": "title" },
                { "data": "date_format" },
                { "data": "start_time" },
                { "data": "end_time" },
                { "data": "start_location"  },
                { "data": "end_location" },
                { "data": "id" }
            ],
            "drawCallback": function() {
                registerEvents();
            },
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
             "columnDefs": [
                {
                    "targets": 6,
                    "render": renderColumnFunction,
                    "sortable": false
                },
                {
                    "targets": 4,
                    "render": renderColumnStartLocation,
                    "sortable": true

                },
                {
                    "targets": 5,
                    "render": renderColumnEndLocation,
                    "sortable": true

                }
            ]
            
        });
    }

    function registerEvents() {
        $("#runs-table button.btn-delete").click(function(e) {
            var id = this.getAttribute('data-id');
            deleteItem(id);
            e.stopPropagation();
        })
    }

    function renderColumnFunction (data, type, row)
    {
        var template = '<a class="link-edit" href="#/runs/detail?id='+row['identifier']+'"><i class="glyphicon glyphicon-chevron-right" aria-hidden="true"></i></a>';
        return template;
    }

    function edit(){
        window.location = "#/runs/detail"
    }

    function search()
    {
        $scope.table.search($scope.keyword).draw() ;
    }

    function add()
    {
        window.location =  location.hash+"/detail";
    }

    function deleteItem(id)
    {
        var c = confirm("Do you want to delete this item?");
        if(c){
            var url = "{0}/{1}".format($scope.api, id);
            DataService.restDelete(url).then(function(){
                $scope.table.ajax.reload();
                DataService.toastDeleteSuccess();
            }, function(error){
                DataService.toastCommonError();
            });
        }
    }

    function renderColumnStartLocation (data){
        return (data.unit_number) ? data.unit_number + '/' + data.street_number + ' ' + data.street_name + ', ' + data.suburb + ', ' + data.state 
            : data.street_number + ' ' + data.street_name + ', ' + data.suburb + ', ' + data.state;
    }

    function renderColumnEndLocation (data){
        return (data.unit_number) ?  data.unit_number + '/' + data.street_number + ' ' + data.street_name + ', ' + data.suburb + ', ' + data.state 
            : data.street_number + ' ' + data.street_name + ', ' + data.suburb + ', ' + data.state;
    }
}
