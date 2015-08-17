var WidgetApp = angular.module('WidgetApp', []);

var CRegistrationUsers = function (options) {
    this.products = options.products;
    this.init();
}
CRegistrationUsers.prototype = {
    'init' : function () {
        var self = this;
        WidgetApp.controller('RegisterUsersController', function($scope, $http) {
            $scope.total  = 0;
            $scope.products = self.products;
            $scope.registration;

            $scope.addEmptyParticipant = function (product, count) {
                for (var $i = 0; $i < count; $i++) {
                    $scope.products[product.Id].participants.push({});
                }
            }

            $scope.fillParticipant = function (product, $index, user) {
                var participant = {};
                $.getJSON('/pay/ajax/addorderitem/', {
                    'ownerRunetId' : user.RunetId,
                    'productId' : product.Id
                }, function (response) {
                    if (typeof(response.error) != "undefined" && response.error) {
                        participant.error = response.message;
                    } else {
                        participant = user;
                        delete participant.error;
                        participant.price = response.price;
                        participant.orderItemId = response.orderItemId;
                    }
                    $scope.products[product.Id].participants[$index] = participant;
                    $scope.calculate();
                    $scope.$apply();
                });
            }

            $scope.removeParticipant = function (product, participant, $index) {
                var participants = $scope.products[product.Id].participants;
                $.getJSON('/pay/ajax/deleteorderitem', {'id' : participant.orderItemId}, function (response) {
                    if (typeof(response.error) != "undefined" && response.error) {
                        participant.error = response.message;
                    } else {
                        participants.splice($index, 1);
                    }
                    $scope.calculate();
                    $scope.$apply();
                });
            }

            $scope.activateCoupon = function (product, participant) {
                $.getJSON('/pay/ajax/couponactivate', {
                    'code' : participant.coupon,
                    'eventIdName' : 'riw14',
                    'ownerRunetId' : participant.RunetId,
                    'productId' : product.Id
                }, function (response) {
                    if (typeof(response.error) != "undefined") {
                        participant.error = response.error;
                    } else {
                        delete participant.error;
                        participant.discount = response.coupon.Discount;
                    }
                    $scope.calculate();
                    $scope.$apply();
                });
            }

            $scope.registerParticipant = function ($event) {
                $event.preventDefault()
                var data = $scope.registration;
                $http.post('/Submit/To/Url', data).success(function(data) {
                    alert('done!');
                });
                console.log(data);

            }

            $scope.calculate = function () {
                $scope.total = 0;
                $.each($scope.products, function (id, product) {
                    var filled = 0;
                    product.total = 0;
                    $.each(product.participants, function (j, participant) {
                        if (typeof (participant.RunetId) !== "undefined") {
                            filled++;
                            product.total += participant.price;
                        } else {
                            product.total += product.Price;
                        }
                    });
                    var count = filled - product.participants.length;
                    if (count >= 0) {
                        $scope.addEmptyParticipant(product, count + 1);
                    }
                    $scope.total += product.total;
                });
            }

            angular.forEach($scope.products, function (product) {
                $scope.addEmptyParticipant(product, product.count > 0 ? product.count : 1);
            });

            $scope.calculate();
        });

        WidgetApp.directive('userautocomplete', function() {
            return function($scope, $element, $attrs) {
                $element.autocomplete({
                    source: '/user/ajax/search',
                    select: function(event, ui) {
                        var product = $element.data('product'),
                            $index  = $element.data('index');

                        $scope.fillParticipant(product, $index, ui.item);
                        $(this).val('');
                        return false;
                    }
                });
            };
        });

        WidgetApp.directive('registration', function() {
            return function($scope, $form, $attrs) {
               $form.submit(function () {
                    $.post('/user/ajax/register', $form.serialize(), function (response) {
                        var $alertError = $form.find('.alert-danger').addClass('hide');
                        if (response.success) {

                        } else {
                            var $errors = $('<ul/>');
                            $.each(response.errors, function (name, error) {
                                $errors.append('<li>' + error + '</li>');
                            });
                            $alertError.html($errors).removeClass('hide');
                        }
                    }, 'json');
                    return false;
               });
            };
        });
    }
}