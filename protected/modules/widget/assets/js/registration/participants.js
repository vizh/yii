var WidgetApp = angular.module('WidgetApp', ['ngSanitize']);

var CRegistrationUsers = function (options) {
    this.eventIdName = options.eventIdName;
    this.products = options.products;
    this.init();
}
CRegistrationUsers.prototype = {
    'init':function () {
        var self = this;
        WidgetApp.controller('RegisterUsersController', function ($scope, $http) {
            $scope.total = 0;
            $scope.products = self.products;
            $scope.free = true;

            $scope.showPayBtn = false;
            $scope.showRegisterBtn = false;

            $scope.addEmptyParticipant = function (product) {
                $scope.products[product.Id].participants.push({});
            }

            $scope.fillParticipant = function (product, $index, user) {
                $scope.products[product.Id].participants[$index] = user;
                $scope.checkUserData(product, user, $index);
            }

            $scope.addOrderItem = function (product, user, $index) {
                self.preloader(true);
                user.userdata = false;
                $.getJSON('/pay/ajax/addorderitem/', {
                    'ownerRunetId':user.RunetId,
                    'productId':product.Id
                }, function (response) {
                    if (typeof(response.error) != "undefined" && response.error) {
                        user = {'error':response.message};
                    } else {
                        user.price = response.price;
                        if (response.price < product.Price) {
                            user.discount = product.Price - response.price;
                        }
                        user.orderItemId = response.orderItemId;
                    }
                    $scope.products[product.Id].participants[$index] = user;
                    $scope.calculate();
                    $scope.$apply();
                    self.preloader(false);
                });
            }

            $scope.removeOrderItem = function (product, participant, $index) {
                self.preloader(true);
                var participants = $scope.products[product.Id].participants;
                $.getJSON('/pay/ajax/deleteorderitem', {'id':participant.orderItemId}, function (response) {
                    if (typeof(response.error) != "undefined" && response.error) {
                        participant.error = response.message;
                    } else {
                        participants.splice($index, 1);
                    }
                    $scope.calculate();
                    $scope.$apply();
                    self.preloader(false);
                });
            }

            $scope.activateCoupon = function (product, participant) {
                self.preloader(true);
                $.getJSON('/pay/ajax/couponactivate', {
                    'code':participant.coupon,
                    'eventIdName':self.eventIdName,
                    'ownerRunetId':participant.RunetId,
                    'productId':product.Id
                }, function (response) {
                    if (typeof(response.error) != "undefined") {
                        participant.error = response.error;
                    } else {
                        delete participant.error;
                        participant.discount = response.coupon.Discount;
                    }
                    $scope.calculate();
                    $scope.$apply();
                    self.preloader(false);
                });
            }

            $scope.showRegistrationForm = function (participant) {
                participant.registration = true;
            }

            $scope.hideRegistrationForm = function (participant) {
                participant.registration = false;
            }

            $scope.hideUserDataForm = function (product, $index) {
                $scope.products[product.Id].participants.splice($index, 1);
                $scope.calculate();
            }

            $scope.checkUserData = function (product, user, $index) {
                self.preloader(true);
                $.getJSON('/pay/ajax/checkuserdata', {
                    'eventIdName':self.eventIdName,
                    'id':user.RunetId
                }, function (response) {
                    if (!response.success) {
                        user.userdata = true;
                        $.each(response.attributes, function (name, value) {
                            user[name] = value;
                        });
                        self.preloader(false);
                        $scope.$apply();
                    } else {
                        $scope.addOrderItem(product, user, $index);
                    }
                })
            }

            $scope.getParticipantClass = function (participant) {
                return (typeof(participant.discount) != "undefined" && participant.discount) ? 'col-xs-7 col-lg-8' : 'col-xs-9';
            }

            $scope.calculate = function () {
                var totalFilled = 0;

                $scope.total = 0;
                $.each($scope.products, function (id, product) {
                    var filled = 0;
                    product.total = 0;
                    $.each(product.participants, function (j, participant) {
                        if (typeof (participant.RunetId) != "undefined") {
                            filled++;
                            product.total += participant.price;
                        }
                    });
                    $scope.total += product.total;
                    if (product.Price > 0) {
                        $scope.free = false;
                    }

                    var count = filled - product.participants.length;
                    if (count >= 0) {
                        for (var i = 0; i <= count; i++) {
                            $scope.addEmptyParticipant(product);
                        }
                    }
                    totalFilled += filled;
                    product.count = filled;
                });

                if (totalFilled > 0) {
                    if ($scope.total > 0) {
                        $scope.showPayBtn = true;
                        $scope.showRegisterBtn = false;
                    } else {
                        $scope.showPayBtn = false;
                        $scope.showRegisterBtn = true;
                    }
                } else {
                    $scope.showPayBtn = $scope.showRegisterBtn = false;
                }
            };
            $scope.calculate();
        });

        WidgetApp.directive('userautocomplete', function () {
            return function ($scope, $element, $attrs) {
                var autocomplete = $element.autocomplete({
                    source:'/user/ajax/search',
                    select:function (event, ui) {
                        var product = $element.data('product'),
                            $index = $element.data('index');

                        $scope.fillParticipant(product, $index, ui.item);
                        $(this).val('');
                        return false;
                    }
                }).data('ui-autocomplete');

                autocomplete._renderMenu = function (ul, items) {
                    var self = this;
                    $.each(items, function (index, item) {
                        self._renderItemData(ul, item);
                    });
                    $(ul).removeClass('ui-autocomplete-bootstrap');
                };

                autocomplete._renderItem = function (ul, item) {
                    var $item = $('<a/>');
                    $item.attr('data-value', item.value);
                    $item.append($('<img/>', {'src':item.Photo.Small}));
                    $item.append('<p>' + item.FullName + ', <span class="text-muted">RUNET-ID ' + item.RunetId + '</span></p>');
                    if (typeof(item.Company) !== "undefined") {
                        $item.append('<p class="text-muted">' + item.Company + '</p>');
                    }
                    return $('<li/>', {'class':'ui-menu-item clearfix'}).append($item).appendTo(ul);
                }

                $element.keyup(function (e) {
                    var $target = $(e.currentTarget);

                    var value = $target.val(),
                        $controlGroup = $target.parent('div');

                    if (value.length > 0) {
                        $controlGroup.attr('class', 'input-group');
                        $controlGroup.find('.input-group-btn').removeClass('hide');
                    } else {
                        $controlGroup.attr('class', 'control-group');
                        $controlGroup.find('.input-group-btn').addClass('hide');
                    }
                });
            };
        });

        WidgetApp.directive('registration', function () {
            return function ($scope, $element, $attrs) {
                var $form = $element.find('form');
                $form.find('input[name*="RegisterForm[Phone]"]').initPhoneInputMask();
                $form.submit(function () {
                    self.preloader(true);
                    $.post('/user/ajax/register', $form.serialize(), function (response) {
                        var $alertError = $form.find('.alert-danger')
                        if (response.success) {
                            $scope.fillParticipant($element.data('product'), $element.data('index'), response.user);
                        } else {
                            var $errors = $('<ul/>');
                            $.each(response.errors, function (name, error) {
                                $errors.append('<li>' + error + '</li>');
                            });
                            $alertError.html($errors).removeClass('hide');
                        }
                        self.preloader(false);
                    }, 'json');
                    return false;
                });
            };
        });

        WidgetApp.directive('userdata', function () {
            return function ($scope, $element, $attrs) {
                var $form = $element.find('form');
                $form.submit(function () {
                    self.preloader(true);
                    var user = $element.data('user');
                    var data = $form.serialize() + '&eventIdName=' + self.eventIdName + '&runetId=' + user.RunetId;
                    $.get('/pay/ajax/edituserdata', data, function (response) {
                        var $alertError = $form.find('.alert-danger');
                        if (response.success) {
                            $scope.addOrderItem($element.data('product'), user, $element.data('index'));
                        } else {
                            var $errors = $('<ul/>');
                            $.each(response.errors, function (name, errors) {
                                $.each(errors, function (i, error) {
                                    $errors.append('<li>' + error + '</li>');
                                });
                            });
                            $alertError.html($errors).removeClass('hide');
                        }
                        self.preloader(false);
                    }, 'json');
                    return false;
                });
            };
        });
    },
    'preloader':function (visible) {
        if (visible) {
            $('#preloader').show();
        } else {
            $('#preloader').hide();
        }
    }
}