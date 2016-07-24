(function (angular) {
    'use strict';

    angular
        .module('app')
        .service('ModalFormFactory', ModalFormFactory);

    function ModalFormFactory($uibModal, $q) {
        this.create = create;

        function create(definition, options) {
            var deferred = $q.defer();
            $uibModal.open({
                templateUrl: 'template/modal-form.html',
                size: 'lg',
                controller: 'ModalFormCtrl',
                controllerAs: 'mfCtrl',
                animation: false,
                resolve: {
                    formDefinition: function () {
                        return definition;
                    },
                    modalOptions: function () {
                        return options;
                    },
                    deferred: function () {
                        return deferred;
                    }
                }
            });
            return deferred.promise;
        }
    }
})(angular);
