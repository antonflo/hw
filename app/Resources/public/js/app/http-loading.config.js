(function (angular) {
    'use strict';

    angular
        .module('app')
        .config(registerInterceptor);

    /**
     * Interceptor for loading indicator
     */
    function registerInterceptor($httpProvider) {
        $httpProvider.interceptors.push(HttpLoadingInterceptor);
    }

    /**
     * Factory for http loading indicator
     */
    function HttpLoadingInterceptor($rootScope, $q) {
        $rootScope.loadingIndicator = {isLoading: false, response: null};
        var indicator = $rootScope.loadingIndicator;
        return {
            request: function (config) {
                indicator.isLoading = true;
                indicator.response = null;
                return config;
            },
            requestError: function (rejection) {
                indicator.isLoading = false;
                indicator.response = rejection;
                return $q.reject(rejection);
            },
            response: function (response) {
                indicator.isLoading = false;
                indicator.response = response;
                return response;
            },
            responseError: function (rejection) {
                indicator.isLoading = false;
                indicator.response = rejection;
                return $q.reject(rejection);
            }
        }
    }
})(angular);
