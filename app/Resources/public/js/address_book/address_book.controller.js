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
        vm.setDefault = setDefault;

        $timeout(load, 500);

        var formFields = [
            {key: 'label', type: 'input', className: 'col-xs-12', templateOptions: {label: 'Label', required: true}},
            {
                className: 'row',
                fieldGroup: [
                    {key: 'firstName', type: 'input', className: 'col-xs-4', templateOptions: {label: 'First Name', required: true}},
                    {key: 'lastName', type: 'input', className: 'col-xs-4', templateOptions: {label: 'Last Name', required: true}},
                    {key: 'phone', type: 'input', className: 'col-xs-4', templateOptions: {label: 'Phone', required: true}}
                ]
            },
            {
                className: 'row',
                fieldGroup: [
                    {key: 'street1', type: 'input', className: 'col-xs-4', templateOptions: {label: 'Street', required: true}},
                    {
                        key: 'street2',
                        type: 'input',
                        className: 'col-xs-4',
                        templateOptions: {label: 'Street 2', required: false},
                        expressionProperties: {
                            'templateOptions.disabled': '!model.street1'
                        }
                    }
                ]
            },
            {
                className: 'row',
                fieldGroup: [
                    {key: 'city', type: 'input', className: 'col-xs-4', templateOptions: {label: 'City', required: true}},
                    {key: 'state', type: 'input', className: 'col-xs-4', templateOptions: {label: 'State', required: false}},
                    {key: 'zip', type: 'input', className: 'col-xs-4', templateOptions: {label: 'ZIP', required: false}}
                ]
            },
            {key: 'country', type: 'input', className: 'col-xs-12', templateOptions: {label: 'Country', required: true}},
            {
                className: 'row',
                fieldGroup: [
                    {key: 'isDefault', type: 'checkbox', className: 'col-xs-12', templateOptions: {label: 'Set as Default', required: false}}
                ]
            }
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

        function setDefault(item) {
            $http({
                url: Routing.generate('address-set-default', {id: item.id}),
                method: 'POST'
            })
                .then(updateData);
        }
    }
})(angular);
