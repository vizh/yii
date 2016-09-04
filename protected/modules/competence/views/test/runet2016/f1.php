<?php
/**
 * @var $form F1
 */

use competence\models\test\runet2016\F1;

$attrs = [
    'class' => 'input-block-level'
];
?>

<style>
    #index-page .ui-autocomplete {
        position: absolute;
        width: 0;
        background: #fff;
        box-shadow: 0 1px 5px rgba(0, 0, 0, .5);
        list-style-type: none;
    }
    #index-page .ui-autocomplete .ui-menu-item a {
        position: relative;
        min-height: 60px;
        padding: 6px 8px;
        display: block;
        color: #333;
        font-size: 13px;
        text-decoration: none;
    }
    #index-page .ui-autocomplete .ui-menu-item:not(:last-child) a {
        border-bottom: 1px solid #e6e6e6;
    }
    #index-page .ui-autocomplete .ui-menu-item a.ui-state-focus {
        background: #eee;
        cursor: pointer;
    }
    #index-page .ui-autocomplete .ui-menu-item a p {
        margin-right: 70px;
        margin-bottom: 0;
    }
    #index-page .ui-autocomplete .ui-menu-item a img {
        position: absolute;
        top: 6px;
        right: 8px;
        border: 1px solid #e6e6e6;
    }
    .form-email {
        display: none;
    }
</style>

<script type="text/template" id="user-autocomlete-tpl">
    <p><%=item.FullName%>, <span class='muted'>RUNET-ID <%=item.RunetId%></span></p>
    <% if (typeof(item.Company) != "undefined") { %>
    <p class='muted'><%=item.Company%><% if (item.Position.length != 0) { %>, <%=item.Position%> <% } %></p>
    <% } %>
    <img src='<%=item.Photo.Small%>' alt='<%=item.FullName%>'>
</script>

<script type="text/template" id="user-row-tpl">
    <tr>
        <td>
            <%=fio%>
            <input type="hidden" name="competence\models\test\runet2016\F1[value][<%=count%>][fio]" value="<%=fio%>">
        </td>
        <td>
            <% if (typeof(runetId) !== "undefined") { %>
            <%=runetId%>
            <input type="hidden" name="competence\models\test\runet2016\F1[value][<%=count%>][runetId]" value="<%=runetId%>">
            <% } else  { %>
            <%=email%>
            <input type="hidden" name="competence\models\test\runet2016\F1[value][<%=count%>][email]" value="<%=email%>">
            <% } %>
        </td>
        <td><a href="#" class="btn btn-small remove-row"><i class="icon-remove"></i></a></td>
    </tr>
</script>


<script type="text/javascript">

    var CExpertsQuestion = function() {
        this.source = '/user/ajax/search/';
        this.templates = {
            autocomplete: _.template($('#user-autocomlete-tpl[type="text/template"]').html()),
            row: _.template($('#user-row-tpl[type="text/template"]').html())
        };
        this.table = $('table.users-table');
        this.formEmail = $('div.form-email');
        this.addUserBtn = $('a.add-user');

        this.count = $('a.remove-row').length;

        this.init();
    };
    CExpertsQuestion.prototype = {
        init: function () {
            var self = this;

            $('a.remove-row').on('click', function(event){
                self.deleteRow(event);
            });
            self.subscribeAutocomplete();

            self.addUserBtn.on('click', function (event) {
                event.preventDefault();
                self.processForm();
            });

            if ($('a.remove-row').length == 0) {
                self.table.hide(0);
            }

        },
        addRow: function (fio, runetId, email) {
            var self = this;
            self.count++;
            $('a.remove-row').off();
            self.table.find('tbody').append(self.templates.row({fio: fio, runetId: runetId, email: email, count: self.count}));
            $('a.remove-row').on('click', function(event){
                self.deleteRow(event);
            });

            if ($('a.remove-row').length > 0) {
                self.table.show(0);
            }
            self.formEmail.hide(0);
            self.clearForm();
        },
        deleteRow: function (event) {
            var self = this;

            event.preventDefault();
            var target = $(event.currentTarget);
            target.parent().parent().remove();

            if ($('a.remove-row').length == 0) {
                self.table.hide(0);
            }
        },
        clearForm: function() {
            $('input.input-user').val('');
            $('input.input-email').val('');
        },
        processForm: function () {
            var self = this;
            self.addRow($('input.input-user').val(), undefined, $('input.input-email').val());
        },
        subscribeAutocomplete: function() {
            var self = this;

            var input = $('input.input-user');
            input.autocomplete({
                minLength: 2,
                position: {
                    collision: 'flip'
                },
                source: self.source,
                select: function(event, ui) {
                    self.addRow(ui.item.FullName, ui.item.RunetId);
                    return false;
                },
                response : function (event, ui) {
                    if (ui.content.length > 0) {
                        $.each(ui.content, function (i) {
                            ui.content[i].label = self.templates.autocomplete({
                                item: ui.content[i]
                            });
                            ui.content[i].value = ui.content[i].FullName + ', '+ 'RUNET-ID ' + ui.content[i].RunetId;
                        });
                        self.formEmail.hide(0);
                    } else {
                        self.formEmail.show(0);
                    }
                },
                html : true
            });
        }
    };

    $(function () {
        var expretsQuestion = new CExpertsQuestion();
    });
</script>

<table class="table table-striped m-bottom_20 users-table">
    <thead>
    <tr>
        <th class="span7">ФИО</th>
        <th class="span4">RUNET-ID или Email</th>
        <th class="span1"></th>
    </tr>
    </thead>

    <tbody>
    <?if (!empty($form->value)):?>
    <?foreach ($form->value as $key => $values):?>
        <tr>
            <td>
                <?=$values['fio'];?>
                <?=CHtml::activeHiddenField($form, 'value[' . $key . '][fio]', ['class' => 'input-block-level']);?>
            </td>
            <td>
                <?if (!empty($values['runetId'])):?>
                    <?=$values['runetId'];?>
                    <?=CHtml::activeHiddenField($form, 'value[' . $key . '][runetId]', ['class' => 'input-block-level']);?>
                <?else:?>
                    <?=$values['email'];?>
                    <?=CHtml::activeHiddenField($form, 'value[' . $key . '][email]', ['class' => 'input-block-level']);?>
                <?endif;?>
            </td>
            <td><a href="#" class="btn btn-small remove-row"><i class="icon-remove"></i></a></td>
        </tr>
    <?endforeach;?>
    <?endif;?>
    </tbody>
</table>

<div class="row m-top_40">
    <div class="span9">
        <input type="text" placeholder="Введите ФИО или RUNET-ID" class="input-block-level input-user">
    </div>
</div>
<div class="row form-email">
    <div class="span7">
        <input type="text" class="input-block-level input-email" placeholder="Email">
    </div>
    <div class="span2"><a href="#" class="btn btn-inverse input-block-level add-user">Добавить</a></div>
</div>