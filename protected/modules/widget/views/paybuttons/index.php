<?php
/**
 * @var \widget\components\Controller $this
 * @var \pay\models\Account $account
 * @var int $total
 */
?>
<?if($total !== 0):?>
<div class="row" style="height: 800px;">
    <div class="col-xs-6 text-right">
        <h5><?=\Yii::t('app', 'Для юр. лиц')?></h5>
        <?$this->widget('\pay\widgets\JuridicalButton', ['account' => $account, 'htmlOptions' => ['class' => 'btn btn-default'], 'url' => ['juridical']])?>
    </div>
    <?if($account->CloudPayments):?>
        <div class="col-xs-6">
            <h5><?=\Yii::t('app', 'Для физ. лиц')?></h5>
            <?$this->renderPartial('index/cloudpayments', ['system' => 'cloudpayments'])?>
        </div>
    <?endif?>
</div>
<?php else:?>
    <div class="alert alert-danger">
        <?=\Yii::t('app', 'У вас нет товаров для оплаты!')?>
    </div>
<?endif?>

