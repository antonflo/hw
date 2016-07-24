(function (angular) {
    'use strict';

    angular
        .module('app')
        .value('Routing', Routing); // registers Routing global variable to be injectable in Angular as a service
})(angular);
