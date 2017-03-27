<?
/**
 * @var \widget\components\Controller $this
 * @var \pay\models\Account $account
 * @var \widget\models\forms\ProductCount $form
 */

/** @var \CClientScript $clientScript */
$clientScript = \Yii::app()->getClientScript();
$clientScript->registerCssFile('/stylesheets/application.css');
$clientScript->registerScript('init', '
    new CRegistrationPay({products : ' . $form->getProductsJson() . '});
', \CClientScript::POS_HEAD);
?>

<div class="event-register" ng-controller="RegisterPayController">
    <table class="table thead-actual">
        <thead>
        <tr>
            <th><?=\Yii::t('app', 'Тип билета')?></th>
            <th class="col-width text-right"><?=\Yii::t('app', 'Цена')?></th>
            <th class="col-width text-center"><?=\Yii::t('app', 'Кол-во')?></th>
            <th class="col-width text-right"><?=\Yii::t('app', 'Сумма')?></th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
    <table class="table product table-striped" ng-repeat="product in products" ng-if="product.participants.length > 0">
        <thead>
        <tr>
            <th>
                <h4 class="title">{{product.Title}} <i class="icon-chevron-up"></i></h4>
            </th>
            <th class="col-width text-right">
                <span class="number">{{product.Price}} <?=\Yii::t('app', 'руб.')?></span>
            </th>
            <th class="col-width text-center"><span class="number quantity">{{product.participants.length}}</span></th>
            <th class="col-width text-right"><b class="number mediate-price">{{product.total}}  <?=\Yii::t('app', 'руб.')?></b></th>
        </tr>
        </thead>
        <tbody>
        <tr ng-repeat="participant in product.participants">
            <td colspan="4">
                <div class="row">
                    <div class="col-xs-10 col-lg-11" >
                        <div class="input-group">
                            {{participant.FullName}}, RUNET-ID {{participant.RunetId}}
                        </div>
                    </div>
                    <div class="col-xs-2 col-lg-1 text-center discount" ng-if="participant.discount !== undefined && participant.discount > 0" >
                        <strong class="text-success">
                            - {{participant.discount}} <?=\Yii::t('app', 'руб.')?>
                        </strong>
                    </div>
                </div>
            </td>
        </tr>
        </tbody>
    </table>

    <table class="product table">
        <tbody>
        <tr>
            <td colspan="4" class="total text-right">
                <?=Yii::t('app', 'ИТОГО')?>: <b id="total-price" class="number">{{total}}</b> <?=Yii::t('app', 'руб.')?>
            </td>
        </tr>
        </tbody>
    </table>

    <div class="row">
        <div class="col-xs-12 text-center">
            <div class="checkbox text-danger">
                <label>
                    <input type="checkbox" ng-model="offer"> <strong><?=\Yii::t('app', 'Я согласен с условиями <a target="_blank" href="{url}">договора-оферты</a> и готов перейти к оплате', ['{url}' => $this->createUrl('/pay/cabinet/offer', ['eventIdName' => $this->getEvent()->IdName])])?></strong>
                </label>
            </div>
            <hr/>
        </div>
    </div>
    <div class="row pay-buttons actions">
        <div class="col-sm-5">
            <h5><?=\Yii::t('app', 'Для юр. лиц')?></h5>
            <?$this->widget('\pay\widgets\JuridicalButton', ['account' => $account, 'htmlOptions' => ['class' => 'btn btn-default btn-lg', 'ng-class' => '{\'btn-primary\' : offer}', 'ng-disabled' => '!offer'], 'url' => ['juridical']])?>
        </div>
        <div class="col-sm-7">
            <?$this->widget('\pay\widgets\PayButtons', ['account' => $account, 'htmlOptions' => ['class' => 'btn btn-default', 'ng-class' => '{\'btn-primary\' : offer}', 'ng-disabled' => '!offer', 'target' => '_top']])?>
        </div>
    </div>
    <div class="text-center">
        <?=\CHtml::link(\Yii::t('app', 'Назад'), ['participants'], ['class' => 'btn btn-default btn-lg'])?>
    </div>
</div>