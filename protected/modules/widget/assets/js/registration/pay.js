var WidgetApp = angular.module('WidgetApp', ['ngSanitize']);

var CRegistrationPay = function (options) {
    this.products = options.products;
    this.init();
}
CRegistrationPay.prototype = {
    'init':function () {
        var self = this;
        WidgetApp.controller('RegisterPayController', function ($scope, $sce) {
            $scope.total = 0;
            $scope.products = self.products;
            $scope.offer = false;

            $scope.calculate = function () {
                $scope.total = 0;
                $.each($scope.products, function (id, product) {
                    product.total = 0;
                    $.each(product.participants, function (i, participant) {
                        product.total += participant.price;
                    });
                    $scope.total += product.total;
                });
            }

            $scope.calculate();
        });
    }
}