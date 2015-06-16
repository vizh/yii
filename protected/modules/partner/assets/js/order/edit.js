
var COrderEdit = function() {
    this.$orderItems = $('table#order-items tbody');
    this.init();
}
COrderEdit.prototype = {
    init : function () {
        var self = this;
        this.loadOrderItem();
        this.initNewOrderItemForm();
    },
    loadOrderItem : function () {
        var self = this;
        self.$orderItems.html('<tr><td colspan="4" class="muted" style="text-align: center">Идет загрузка...</td></tr>');

        var data = $.extend({}, self.additionalData || {});
        data['method'] = 'getItemsList';
        $.getJSON('', data, function (response) {
            self.$orderItems.html('');
            $.each(response, function (i, item) {
                var tr = $('<tr/>', {
                    'html' : '<td>'+item.Owner+'</td><td>'+item.Product+'</td><td>'+item.Price+'</td><td class="text-right"><a href="#" class="btn btn-danger"><span class="fa fa-times"></span></a></td>'
                });
                tr.data('order-item-id', item.Id);
                tr.find('.btn.btn-danger').click(function (e) {
                    e.preventDefault();
                    if (confirm("Вы точно хотите удалить этот заказ?")){
                        $.getJSON('', {'method' : 'deleteItem', 'OrderItemId' : tr.data('order-item-id')}, function (result) {
                            if (result.success) {
                                tr.remove();
                            }
                            else {
                                self.showModal('Ошибка!', result.message);
                            }
                        });
                    }
                });
                self.$orderItems.append(tr);
            });
        });
    },

    initNewOrderItemForm : function () {
        var self = this,
            $tableFoot = self.$orderItems.parent('table').find('tfoot'),
            $button = $tableFoot.find('button.add-order-item');

        $tableFoot.find('input[type="text"]:eq(0)').autocomplete({
            'minLength' : 2,
            'source' : '/user/ajax/search',
            'select' : function (event, ui) {
                $tableFoot.find('input[name="RunetId"]').val(ui.item.value);
                $(this).val(ui.item.label);
                return false;
            }
        })

        $button.click(function (e) {
            e.preventDefault();
            var data = $tableFoot.find('input,select').serializeArray();
            data.push({'name' : 'method', 'value' : 'createItem'});
            $tableFoot.find('input,select').val('');
            $.getJSON('', data, function (response) {
                if (response.success) {
                    self.loadOrderItem();
                } else {
                    self.showModal('Ошибка!', response.message);
                }
            });
        });
    },

    showModal : function (title, text) {
        var $modal = $('<div/>', {
            'class' : 'modal fade modal-blur'
        });
        $modal.html(
            '<div class="modal-dialog">' +
               '<div class="modal-content">' +
                    '<div class="modal-header">' +
                        '<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>' +
                        '<h4 id="myModalLabel" class="modal-title">' + title + '</h4>' +
                    '</div>' +
                    '<div class="modal-body">' + text + '</div>' +
                '</div>' +
            '</div>'
        );
        $modal.on('hidden.bs.modal', function () {
            $modal.remove();
        });
        $('body').append($modal);
        $modal.modal('show');
    }
}

$(function () {
   new COrderEdit();
});