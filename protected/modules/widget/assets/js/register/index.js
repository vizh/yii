var WidgetApp = angular.module('WidgetApp', []);

var CRegistrationIndex = function (options) {
    this.products = options.products;
    this.init();
}
CRegistrationIndex.prototype = {
    'init' : function () {
        var self = this;
        WidgetApp.controller('RegisterIndexController', function($scope) {
            $scope.total  = 0;
            $scope.products = self.products;
            $scope.$watch('products', function() {
                var total = 0;
                $scope.products.forEach(function(product) {
                    total += product.count * product.Price;
                });
                $scope.total = total;
            }, true);
        });
    }
}