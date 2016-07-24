(function (angular) {
    'use strict';

    angular
        .module('app')
        .controller('AddressBookCtrl', AddressBookCtrl);

    function AddressBookCtrl($timeout, $http, Routing, ModalFormFactory) {
        var vm = this;
        vm.data = [];
        vm.create = create;
        vm.edit = edit;

        $timeout(load, 500);

        var formFields = [
            {key: 'label', type: 'input', templateOptions: {label: 'Label', required: true}},
            {key: 'firstName', type: 'input', templateOptions: {label: 'First Name', required: true}},
            {key: 'lastName', type: 'input', templateOptions: {label: 'Last Name', required: true}}
        ];

        function load() {
            $http({url: Routing.generate('address-book-data'), method: 'GET'})
                .then(updateData);
        }

        function updateData(response) {
            vm.data.length = 0;
            vm.data = [].concat(response.data);
        }

        function create() {
            var definition = {
                data: {},
                url: Routing.generate('address-create'),
                fields: formFields
            };
            var options = {title: 'Create Address'};
            ModalFormFactory.create(definition, options)
                .then(updateData);
        }

        function edit(item) {
            var definition = {
                data: angular.copy(item),
                url: Routing.generate('address-update', {id: item.id}),
                fields: formFields
            };
            var options = {
                title: 'Edit Address',
                delete: {
                    url: Routing.generate('address-delete', {id: item.id})
                }
            };
            ModalFormFactory.create(definition, options)
                .then(updateData);
        }
    }
})(angular);
