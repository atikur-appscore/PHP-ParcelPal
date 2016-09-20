
appControllers.controller('UserCtrl', UserController);
UserController.$inject = ['$scope', '$rootScope', '$timeout', '$q', 'DataService', 'TranslateService', '$location', 'toaster', 'DataService'];

function UserController($scope, $rootScope, $timeout, $q, DataService, TranslateService, $location, toaster) {

    $scope.api = "user";
    $scope.tableID = "user-table";
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
                { "data": "first_name" },
                { "data": "last_name" },
                { "data": "birthday" },
                { "data": "email" },
                { "data": "gender_id" },
                { "data": "location" },
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
                    "targets": 4,
                    "render": renderColumnGender,
                    "sortable": true
                },
                {
                    "targets": 6,
                    "render": renderColumnFunction,
                    "sortable": false

                }
            ]
        });
    }

    function registerEvents() {
        $("#user-table button.btn-delete").click(function(e){
            var id = this.getAttribute('data-id');
            deleteItem(id);
            e.stopPropagation();
        })
    }

    function renderColumnGender (data){
        if (data == "1"){
            return "Male";
        }else{
            return "Female";
        }
    }
    
    function renderColumnFunction  ( data, type, row ) {
        var template = '<button class="form-control btn-delete" data-id="'+row['id']+'">Delete</button>' +
            '<a class="link-edit" href="#/user/detail?id='+row['id']+'"><i class="glyphicon glyphicon-chevron-right" aria-hidden="true"></i></a>';
        return template;
    }

    function edit(){
        window.location = "#/user/detail"
    }

    function search(){
        $scope.table.search($scope.keyword).draw() ;
    }

    function add(){
        window.location =  location.hash+"/detail";
    }

    function deleteItem(id) {
        var isDelete = confirm("Do you want to delete this item?");
        if(isDelete) {
            var url = "{0}/{1}".format($scope.api, id);
            DataService.restDelete(url).then(function() {
                $scope.table.ajax.reload();
                DataService.toastDeleteSuccess();
            }, function(error){
                DataService.toastCommonError();
            });
        }
    }
}
