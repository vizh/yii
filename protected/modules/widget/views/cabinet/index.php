<?
/**
 * @var \widget\components\Controller $this
 * @var \widget\models\forms\ProductCount $form
 * @var CActiveForm $activeForm
 */
?>
<div class="container-fluid">
<?php $activeForm = $this->beginWidget('CActiveForm', ['htmlOptions' => ['ng-controller' => 'CabinetIndexController']]);?>
    <table class="table table-striped products">
        <thead>
            <th></th>
            <th class="text-right"><?=\Yii::t('app', 'Цена');?></th>
            <th class="text-center"><?=\Yii::t('app', 'Кол-во');?></th>
            <th class="text-right"><?=\Yii::t('app', 'Сумма°');?></th>
        </thead>
        <tbody>
            <?php foreach ($form->getProducts() as $product):?>
                <tr>
                    <td><strong><?=$product->Title;?></strong></td>
                    <td class="text-right">
                        <?php if ($product->getPrice() !== 0):?>
                            <span class="number"><?=$product->getPrice();?></span> <?=Yii::t('app', 'руб.');?>
                        <?php else:?>
                            <?=Yii::t('app', 'бесплатно');?>
                        <?php endif;?>
                    </td>
                    <td class="text-center">
                        <?=$activeForm->dropDownList($form, 'Count[' . $product->Id . ']', [0,1,2,3,4,5,6,7,8,9,10], ['ng-model' => 'product', 'ng-change' => 'change()']);?>
                    </td>
                    <td class="text-right"><b class="number">0</b> <?=Yii::t('app', 'руб.');?></td>
                </tr>
            <?php endforeach;?>
            <tr>
                <td colspan="5" class="total text-right">
                    <span><?=Yii::t('app', 'Итого');?>:</span> <b id="total-price" class="number">{{count}}</b> <?=Yii::t('app', 'руб.');?>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="row">
        <div class="col-sm-6">
            <img src="/img/pay/pay-methods.png" class="pull-left" alt="<?=\Yii::t('app', 'Поддерживаемые способы оплаты');?>"/>
        </div>
        <div class="col-sm-6 text-right"><?=\CHtml::submitButton(\Yii::t('app', 'Зарегистрироваться'), ['class' => 'btn btn-primary']);?></div>
    </div>
<?php $this->endWidget();?>
</div>
