(function (angular) {
    'use strict';

    angular
        .module('app')
        .run(HttpCrashListener);

    /**
     * Watches uncaught erroneous HTTP requests and displays a crash message
     */
    function HttpCrashListener($rootScope) {
        $rootScope.$watch('loadingIndicator.isLoading', onChange);

        function onChange() {
            var indicator = $rootScope.loadingIndicator;
            if (indicator.response && indicator.response.status != 200 && !indicator.response.isHandled) {
                alert('Unexpected error: HTTP ' + indicator.response.status + ' ' + indicator.response.statusText);
            }
        }
    }
})(angular);
