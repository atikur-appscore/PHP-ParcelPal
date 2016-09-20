/**
 * Created by Brian on 3/13/2016.
 */


angular.module('angularApp')
    .factory('TranslateService', ['$timeout', '$http', '$q', 'toaster',
        function ($timeout, $http, $q, toaster) {

            var service = {};

            service.gender = translateGender;

            return service;

            function translateGender(gender_id){
                return gender_id == "1" ? "Male" : "Female";
            }
        }]);
