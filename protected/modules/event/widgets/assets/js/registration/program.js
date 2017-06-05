var CRegistrationProgram = function () {
    this.sentRequest = false;
    this.cssClasses = {
        'orderItemExists':'bg-warning',
        'orderItemPaid':'bg-success',
        'notForSale':'bg-muted muted',
        'disabled':'bg-muted'
    };
    this.$widget = $('#event_widgets_registration_Program');
    this.$tabs = this.$widget.find('.tabs');
    this.$grid = this.$widget.find('table');
    this.$sections = this.$grid.find('[data-product]:not([data-notforsale]):not([data-paid])');
    this.oneOnLineMode = this.$widget.data('oneonline-mode') == 1;
    this.$total = this.$widget.find('.total');
    this.isInitialized = false;
}
CRegistrationProgram.prototype = {
    'init':function () {
        var self = this;

        self.initTabs();

        self.isInitialized = true;
        self.$grid.find('tr:not(.info) td:not([data-product]):not(.time)').addClass(self.cssClasses.disabled);
        self.$grid.find('[data-notforsale]:not([data-paid])').data('notforsale', 1).addClass(self.cssClasses.notForSale);
        self.$grid.find('[data-paid]').addClass(self.cssClasses.orderItemPaid);

        self.$sections.find('.btn-register').click(function (e) {
            var $target = $(e.currentTarget);
            self.addOrderItem($target.parents('td'));
            e.preventDefault();
        });

        self.$sections.find('.btn-unregister').click(function (e) {
            var $target = $(e.currentTarget);
            self.deleteOrderItem($target.parents('td'));
            e.preventDefault();
        });

        self.$sections.css('cursor', 'pointer');
        self.$sections.filter('[data-orderitem]').addClass(self.cssClasses.orderItemExists);
        if (self.oneOnLineMode) {
            self.$grid.find('[data-orderitem]').each(function () {
                $(this).siblings('[data-product]:not([data-notforsale])').addClass(self.cssClasses.notForSale);
            });
        }
        self.$grid.find('td').hover(function () {
            self.hoverSection($(this));
        }, function () {
            $(this).find('.registration-block').hide();
        });

        self.$total.pin({
            'padding':self.getPinPadding(),
            'containerSelector':'#' + self.$widget.attr('id')
        });

        self.calcTotal();
    },

    'initTabs':function () {
        var self = this;
        self.$tabs.find('.nav a').off('click');
        self.$tabs.tabs();
    },

    'addOrderItem':function ($section) {
        var self = this,
            product = $section.data('product');

        if (self.sentRequest) {
            return;
        }
        if (self.$widget.data('user') == '') {
            modalAuthObj.login();
            return;
        }

        self.showLoader();
        $.get('/pay/ajax/addorderitem', {'productId':product, 'ownerRunetId':self.$widget.data('user')}, function (response) {
            if (response.success == true) {
                $section.data('price', response.price).data('orderitem', response.orderItemId);
                $section.removeClass(self.cssClasses.itemHover);
                $section.addClass(self.cssClasses.orderItemExists);
                if (self.oneOnLineMode) {
                    $section.siblings('[data-product]:not(:data(notforsale))').addClass(self.cssClasses.notForSale);
                }
                self.hoverSection($section);
                self.calcTotal();
            } else {
                self.showErrorMessage(response);
            }
            self.hideLoader();
        }, 'json');
    },

    'deleteOrderItem':function ($section) {
        var self = this;
        if (self.sentRequest) {
            return;
        }
        self.showLoader();
        $.get('/pay/ajax/deleteorderitem', {'id':$section.data('orderitem')}, function (response) {
            if (response.success == true) {
                $section.removeData('orderitem').removeAttr('data-orderitem');
                $section.removeClass(self.cssClasses.orderItemExists);
                if (self.oneOnLineMode) {
                    $section.siblings('[data-product]:not(:data(notforsale))').removeClass(self.cssClasses.notForSale);
                }
                self.hoverSection($section);
                self.calcTotal();
            } else {
                self.showErrorMessage(response);
            }
            self.hideLoader();
        }, 'json');
    },

    'showErrorMessage':function (response) {
        var self = this,
            $modal = $('<div/>', {'class':'modal'});

        $modal.html(
            '<div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h3>Ошибка!</h3></div>' +
            '<div class="modal-body"><h4 class="text-error text-center">' + response.message + '</h4></div>' +
            '<div class="modal-footer"><a href="#" class="btn" data-dismiss="modal">Закрыть</a></div>'
        );
        $modal.on('hidden', function () {
            $modal.remove();
        })
        $modal.modal('show');
    },

    'calcTotal':function () {
        var self = this,
            totalPrice = 0,
            allSectionCount = 0,
            newSectionCount = 0;

        var $button = self.$total.find('a.btn-success');

        self.$grid.find('[data-orderitem], :data(orderitem)').each(function () {
            if ($(this).data('paid') != 1) {
                newSectionCount++;
                totalPrice += $(this).data('price');
            }
            allSectionCount++;
        });

        if (newSectionCount > 0) {
            $button.text(totalPrice == 0 ? 'Зарегистрироваться' : 'Перейти к оплате').removeClass('hide');
        } else {
            $button.addClass('hide');
        }

        self.$total.find('#total-section').text(allSectionCount);
        self.$total.find('#total-price').text(totalPrice);
    },

    'showLoader':function () {
        self.sentRequest = true;
        this.$widget.css('opacity', 0.2);
    },

    'hideLoader':function () {
        this.sentRequest = false;
        this.$widget.css('opacity', 1);
    },

    hoverSection:function ($section) {
        var $registration = $section.find('.registration-block');
        $registration.find('.btn:not([data-toggle])').addClass('hide');
        if (!$section.hasClass(this.cssClasses.notForSale) && !$section.hasClass(this.cssClasses.orderItemPaid)) {
            var orderItem = $section.data('orderitem');
            if (typeof(orderItem) == "undefined" || orderItem == '') {
                $section.find('p.limit').show();
                $registration.find('.btn.btn-register').removeClass('hide');
            } else {
                $section.find('p.limit').hide();
                $registration.find('.btn.btn-unregister').removeClass('hide');
            }
        }
        if ($registration.find('.btn:not(.hide)').size() > 0) {
            $registration.slideDown(200);
        }
    },

    changeLimit:function ($section, $opeation) {
        var $limit
    },

    getPinPadding:function () {
        var padding = {'top':0};
        var $navbar = $('header#header .navbar');
        if ($navbar.is(':visible')) {
            padding.top = $navbar.height();
        }
        return padding;
    }
}

$(function () {
    var registrationProgram = new CRegistrationProgram();

    function initRegistrationProgram() {
        if (!registrationProgram.isInitialized && registrationProgram.$widget.is(':visible')) {
            registrationProgram.init();
        }
    }

    initRegistrationProgram();
    $('#event-tabs').on('tabsactivate', function (event, ui) {
        initRegistrationProgram();
    });
});