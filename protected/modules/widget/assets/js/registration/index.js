var WidgetApp = angular.module('WidgetApp', ['ngSanitize']);

var CRegistrationIndex = function (options) {
    this.products = options.products;
    this.init();
}
CRegistrationIndex.prototype = {
    'init':function () {
        var self = this;
        WidgetApp.controller('RegisterIndexController', function ($scope, $sce) {
            $scope.total = 0;

            var products = [];
            for (var id in self.products) {
                products.push(self.products[id]);
            }

            $scope.products = products;
            $scope.free = false;

            $scope.$watch('products', function () {
                $scope.total = 0;
                $.each($scope.products, function (id, product) {
                    product.total = product.count * product.Price;

                    $scope.total += product.total;
                });
            }, true);
        })
            .filter('to_trusted', ['$sce', function ($sce) {
                return function (text) {
                    return $sce.trustAsHtml(text);
                };
            }]);

    }
}