<?php
/**
 * @var \widget\components\Controller $this
 * @var \widget\models\forms\ProductCount $form
 * @var CActiveForm $activeForm
 */

/** @var \CClientScript $clientScript */
$clientScript = \Yii::app()->getClientScript();
$clientScript->registerScript('init', '
    new CRegistrationIndex({products : ' . $form->getProductsJson() . '});
', \CClientScript::POS_END);
?>

<div class="container-fluid">
<?$activeForm = $this->beginWidget('CActiveForm', ['htmlOptions' => ['ng-controller' => 'RegisterIndexController']])?>
    <table class="table table-striped products">
        <thead>
            <th></th>
            <th class="text-center"><?=\Yii::t('app', 'Кол-во')?></th>
            <th class="text-right"><?=\Yii::t('app', 'Цена')?></th>
        </thead>
        <tbody>
            <tr ng-repeat="product in products | orderBy:'-priority'">
                <td>
                    <strong>{{product.Title}}</strong>
                    <div class="text-muted m-top_5" ng-bind-html="product.Description" ng-if="product.Description"></div>
                </td>
                <td class="text-center col-width">
                    <?=\CHtml::tag('select', ['ng-model' => 'product.count', 'ng-options' => 'option for option in [0,1,2,3,4,5,6,7,8,9,10]'])?>
                    <?=$activeForm->hiddenField($form, 'Count[{{product.Id}}]', ['value' => '{{product.count}}'])?>
                </td>
                <td class="text-right col-width">
                    <strong>{{product.Price != 0 ? product.Price  + " <?=Yii::t('app', 'руб.')?>" : "<?=\Yii::t('app', 'Бесплатно')?>"}}</strong>
                    <p ng-repeat="price in product.futurePrices" class="future-price text-muted">
                        {{price.Title}} {{price.Price}} <?=Yii::t('app', 'руб.')?>
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="4" class="total text-right">
                    <span><?=Yii::t('app', 'Итого')?>:</span> <b id="total-price" class="number">{{total}}</b> <?=Yii::t('app', 'руб.')?>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="row">
        <div class="col-sm-6">
            <img src="/img/pay/pay-methods.png" class="pull-left" alt="<?=\Yii::t('app', 'Поддерживаемые способы оплаты')?>"/>
        </div>
        <div class="col-sm-6 text-right"><?=\CHtml::submitButton(\Yii::t('app', 'Зарегистрироваться'), ['class' => 'btn btn-primary'])?></div>
    </div>
<?$this->endWidget()?>
</div>
