var PartnerApp = angular.module('PartnerApp', ['ngSanitize']);

var COrderEdit = function (payerRunetId, orderId) {
    this.payerRunetId = payerRunetId;
    this.orderId = orderId;
    this.init();
}
COrderEdit.prototype = {
    'init':function () {
        var self = this;
        PartnerApp.controller('OrderEditController', function ($scope, $http) {
            $scope.newOrderItem = {};
            $scope.orderItems = [];
            $scope.loading = false;

            $scope.getOrderItems = function () {
                var params = {payerRunetId:self.payerRunetId};
                if (typeof(self.orderId) != "undefined") {
                    params.orderId = self.orderId;
                }
                $scope.loading = true;
                $.getJSON('/ajax/orderitems', params, function (response) {
                    $scope.orderItems = response
                    $scope.loading = false;
                    $scope.$apply();
                });
            }

            $scope.addOrderItem = function (orderItem, $index) {
                $scope.newOrderItem.payerRunetId = self.payerRunetId;
                if (typeof(self.orderId) != "undefined") {
                    $scope.newOrderItem.orderId = self.orderId;
                }
                $scope.loading = true;
                $.getJSON('/ajax/addorderitem', $scope.newOrderItem, function (response) {
                    if (typeof(response.error) != "undefined" && response.error) {
                        $scope.newOrderItem.error = response.message;
                        $scope.loading = false;
                    } else {
                        $('table#order-items input').val('');
                        $scope.getOrderItems();
                    }
                    $scope.$apply();
                });
            }

            $scope.removeOrderItem = function (orderItem, $index) {
                var params = {'id':orderItem.Id, 'payerRunetId':self.payerRunetId};
                if (typeof(self.orderId) != "undefined") {
                    params.orderId = self.orderId;
                }
                $scope.loading = true;
                $.getJSON('/ajax/deleteorderitem', params, function (response) {
                    if (typeof(response.success) != "undefined" && response.success) {
                        $scope.orderItems.splice($index, 1);
                    }
                    $scope.getOrderItems();
                });
            }

            $scope.getOrderItems();
        });
    }
}

PartnerApp.directive('userautocomplete', function () {
    return function ($scope, $element, $attrs) {
        $element.autocomplete({
            source:'/user/ajax/search',
            select:function (event, ui) {
                $element.val(ui.item.label);
                $scope.newOrderItem.ownerRunetId = ui.item.value;
                return false;
            }
        });
    };
});