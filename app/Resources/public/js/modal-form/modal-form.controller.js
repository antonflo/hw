(function (angular) {
    'use strict';

    angular
        .module('app')
        .controller('ModalFormCtrl', ModalFormCtrl);

    function ModalFormCtrl($uibModalInstance, $http, formDefinition, modalOptions, deferred) {
        var vm = this;

        vm.formData = formDefinition.data;
        vm.formFields = formDefinition.fields;
        vm.url = formDefinition.url;
        vm.title = modalOptions.title;
        vm.errorMessage = null;
        if (modalOptions.delete) {
            vm.delete = deleteCallback;
        }

        vm.submit = submit;
        vm.dismissError = dismissError;

        function submit() {
            if (vm.form.$valid) {
                var data;
                data = angular.copy(vm.formData);
                $http({
                    method: 'POST',
                    url: vm.url,
                    data: data
                })
                    .then(resolveDeferred, handleFailed)
                    .then($uibModalInstance.close)
                ;
            } else {
                angular.forEach(vm.formFields, function (field) {
                    if (field.formControl) {
                        field.formControl.$setTouched();
                    }
                });
                vm.errorMessage = 'Invalid input. Please check and try again.'
            }
        }

        function resolveDeferred(result) {
            deferred.resolve(result);
            return deferred.promise;
        }

        function deleteCallback() {
            $http({
                url: modalOptions.delete.url,
                method: 'POST',
                data: modalOptions.delete.data || ''
            })
                .then(resolveDeferred, handleFailed)
                .then($uibModalInstance.close)
            ;
        }

        function handleFailed(response) {
            response.isHandled = true;
            if (response.status == 400 && response.data && response.data.message) {
                vm.errorMessage = response.data.message;
            } else {
                vm.errorMessage = 'HTTP ' + response.status + ' ' + response.statusText;
            }
            deferred.reject(response);
            return deferred.promise;
        }

        function dismissError() {
            vm.errorMessage = null;
        }
    }
})(angular);
