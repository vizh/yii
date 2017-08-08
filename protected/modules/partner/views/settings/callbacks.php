<?php

/**
 * @var \partner\components\Controller $this
 * @var \partner\models\PartnerCallback[] $callbacks
 */

use partner\models\PartnerCallback;

$this->setPageTitle(Yii::t('app', 'Обратные вызовы'));

$labels = (new PartnerCallback())->attributeLabels();

?>

<div id="partner-callbacks" xmlns:v-on="http://www.w3.org/1999/xhtml" xmlns:v-bind="http://www.w3.org/1999/xhtml">
    <div class="panel panel-info" v-for="callback in callbacks">
        <div class="panel-heading">
            <span class="panel-title"><i class="fa fa-list"></i> <?=Yii::t('app', 'Обратные вызовы')?></span>
        </div>
        <div class="panel-body">
            <form class="form-horizontal">
                <div class="alert alert-danger" v-if="error&&error.Message">{{ error.Message }}</div>
                <fieldset>
                    <legend>Заказы</legend>
                    <div v-bind:class="{'has-error':error&&error.Fields&&error.Fields.OnOrderPaid}" class="row form-group">
                        <label class="col-sm-3 control-label"><?=$labels['OnOrderPaid']?>:</label>
                        <div class="col-sm-9">
                            <input v-model="callback.OnOrderPaid" class="form-control">
                            <div class="help-block">
                                {{ error&&error.Fields&&error.Fields.OnOrderPaid ? error.Fields.OnOrderPaid[0] : 'Вызывается в момент оплаты счёта.' }}
                            </div>
                        </div>
                    </div>
                    <div v-bind:class="{'has-error':error&&error.Fields&&error.Fields.OnOrderItemRefund}" class="row form-group">
                        <label class="col-sm-3 control-label"><?=$labels['OnOrderItemRefund']?>:</label>
                        <div class="col-sm-9">
                            <input v-model="callback.OnOrderItemRefund" class="form-control">
                            <div class="help-block">
                                {{ error&&error.Fields&&error.Fields.OnOrderItemRefund ? error.Fields.OnOrderItemRefund[0] : 'Вызывается в момент возврата заказа.' }}
                            </div>
                        </div>
                    </div>
                    <div v-bind:class="{'has-error':error&&error.Fields&&error.Fields.OnOrderItemChangeOwner}" class="row form-group">
                        <label class="col-sm-3 control-label"><?=$labels['OnOrderItemChangeOwner']?>:</label>
                        <div class="col-sm-9">
                            <input v-model="callback.OnOrderItemChangeOwner" class="form-control">
                            <div class="help-block">
                                {{ error&&error.Fields&&error.Fields.OnOrderItemChangeOwner ? error.Fields.OnOrderItemChangeOwner[0] : 'Вызывается в момент смены владельца заказа.' }}
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <legend>Скидки</legend>
                    <div v-bind:class="{'has-error':error&&error.Fields&&error.Fields.OnCouponActivate}" class="row form-group">
                        <label class="col-sm-3 control-label"><?=$labels['OnCouponActivate']?>:</label>
                        <div class="col-sm-9">
                            <input v-model="callback.OnCouponActivate" class="form-control">
                            <div class="help-block">
                                {{ error&&error.Fields&&error.Fields.OnCouponActivate ? error.Fields.OnCouponActivate[0] : 'Возвращает данные: PayerId, OwnerId, ProductId.' }}
                            </div>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
        <div class="panel-footer">
            <ladda v-on:click.native="save(callback)" type="btn-primary">Сохранить</ladda>
            <ladda v-on:click.native="reload">Обновить</ladda>
        </div>
    </div>
</div>