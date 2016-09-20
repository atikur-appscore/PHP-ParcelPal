
angular.module('angularApp')
    .factory('DataService', ['$timeout', '$http', '$q', 'toaster',
        function ($timeout, $http, $q, toaster) {

            var service = {};

            // GET
            service.restGet = function (url, params, isNotification) {
                var defer = $q.defer();

                // Throw error when promise timeout
                var timeoutPromise = $timeout(function() {
                    defer.reject();
                    //handleTimeout();
                }, __requestTimeout);

                // Start request
                $http({
                    method: "get",
                    url: url,
                    params: params,
                    timeout: __requestTimeout
                }).success(function(response) {
                    $timeout.cancel(timeoutPromise);
                    defer.resolve(response)
                }).error(function(error) {
                    $timeout.cancel(timeoutPromise);
                    defer.reject(error);
                });

                return defer.promise;
            };

            // POST
            service.restPost = function (url, params, isNotification) {
                params['_token'] = __csrf;
                var defer = $q.defer();

                // Throw error when promise timeout
                var timeoutPromise = $timeout(function() {
                    defer.reject();
                    //handleTimeout();
                }, __requestTimeout);

                // Start request
                $http({
                    method: "post",
                    url: url,
                    data: params,
                    timeout: __requestTimeout
                }).success(function(response) {
                    $timeout.cancel(timeoutPromise);
                    defer.resolve(response);
                }).error(function(error) {
                    $timeout.cancel(timeoutPromise);
                    defer.reject(error);
                });

                return defer.promise;
            };

            // PUT
            service.restPut = function (url, params, isNotification) {
                params['_token'] = __csrf;
                var defer = $q.defer();

                // Throw error when promise timeout
                var timeoutPromise = $timeout(function() {
                    defer.reject();
                    //handleTimeout();
                }, __requestTimeout);

                // Start request
                $http({
                    method: "put",
                    url: url,
                    data: params,
                    timeout: __requestTimeout
                }).success(function(response) {
                    $timeout.cancel(timeoutPromise);
                    defer.resolve(response);
                }).error(function(error) {
                    $timeout.cancel(timeoutPromise);
                    defer.reject(error);
                });

                return defer.promise;
            };

            // DELETE
            service.restDelete = function (url, params) {
                var defer = $q.defer();

                // Throw error when promise timeout
                var timeoutPromise = $timeout(function() {
                    defer.reject();
                    //handleTimeout();
                }, __requestTimeout);

                // Start request
                $http({
                    method: "delete",
                    url: url,
                    params: params,
                    timeout: __requestTimeout
                }).success(function(response) {
                    $timeout.cancel(timeoutPromise);
                    defer.resolve(response);
                }).error(function(error) {
                    $timeout.cancel(timeoutPromise);
                    defer.reject(error);
                });

                return defer.promise;
            };

            // TOASTER

            service.toastInsertSuccess = function(){
                toaster.pop({
                    type: 'success',
                    title: 'Item created successfully.',
                    showCloseButton: true
                });
            };

            service.toastUpdateSuccess = function(){
                toaster.pop({
                    type: 'success',
                    title: 'Item updated successfully.',
                    showCloseButton: true
                });
            };
            
            service.toastDeleteSuccess = function(){
                toaster.pop({
                    type: 'success',
                    title: 'Item deleted successfully.',
                    showCloseButton: true
                });
            };

            service.toastResetPasswordSuccess = function(){
                toaster.pop({
                    type: 'success',
                    title: 'Reset password successfully.',
                    showCloseButton: true
                });
            };

            service.toastCommonError = function(e){
                var e = e || {};
                toaster.pop({
                    type: 'error',
                    title: e.message || 'Error',
                    showCloseButton: true
                });
            };

            service.toastLoginError = function(){
                toaster.pop({
                    type: 'error',
                    title: 'Invalid user credentials.',
                    showCloseButton: true
                });
            };

            service.toastResetPasswordError = function(){
                toaster.pop({
                    type: 'error',
                    title: 'Invalid user credentials.',
                    showCloseButton: true
                });
            };
            return service;
        }]);
