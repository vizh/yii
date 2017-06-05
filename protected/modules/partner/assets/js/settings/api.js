var PartnerApp = angular.module('PartnerApp', ['ngSanitize']);

var CApiSettings = function (attributes) {
    this.attributes = attributes;
    this.init();
}
CApiSettings.prototype = {
    'init':function () {
        var self = this;
        PartnerApp.controller('ApiSettingsController', function ($scope, $http) {
            $scope.domains = [];
            $.each(self.attributes.Domains, function (i, domain) {
                $scope.domains.push({'domain':domain});
            });

            $scope.removeDomain = function ($index) {
                $scope.domains.splice($index, 1);
            }
            $scope.addDomain = function () {
                $scope.domains.push({'domain':''});
            }
        });
    }
}