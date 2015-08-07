angular.module('widget', []).controller('CabinetIndexController', [
    '$scope',
    function($scope) {
        $scope.total = 0;
        $scope.change = function () {
            alert('123');
        }
    }
]);