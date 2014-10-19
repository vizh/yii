<?php
/**
 * @var $products \pay\models\Product[]
 * @var $form \partner\models\forms\coupon\Generate
 * @var $result \pay\models\Coupon[]
 * @var $event \event\models\Event
 */
$productDropDown = array();
$productDropDown[0] = 'На все типы продуктов';
foreach ($products as $product) {
    $productDropDown[$product->Id] = $product->Title;
}
?>

    <div class="row">
        <div class="span12 indent-bottom3">
            <h2>Генерация промо-кодов</h2>
        </div>
    </div>

<?if ($form->hasErrors()):?>
    <div class="row">
        <div class="span8 offset1">
            <?=CHtml::errorSummary($form, '<div class="alert alert-error">', '</div>', []);?>
        </div>
    </div>
<?endif;?>

<?if (count($result) > 0):?>
    <div class="row">
        <div class="span8 offset1">
            <div class="alert alert-success">
                <p>
                    <?=count($result) > 1 ? 'Сгенерированы промо-коды:' : 'Сгенерирован промо-код';?>
                </p>
                <p>
                    <?foreach ($result as $coupon):?>
                        <code><?=$coupon->Code;?></code><br>
                    <?endforeach;?>
                </p>
            </div>
        </div>
    </div>
<?endif;?>

<?=CHtml::beginForm();?>
    <div class="row indent-bottom3 coupon-type">
        <div class="span1">&nbsp;</div>
        <?foreach ($form->getTypes() as $key => $title):?>
            <div class="span2">
                <label class="radio">
                    <?=CHtml::activeRadioButton($form, 'type', ['value' => $key, 'uncheckValue' => null, 'data-target' => $key]);?>
                    <?=$title;?>
                </label>
            </div>
        <?endforeach;?>
    </div>

    <div class="row">
        <div class="span10 offset1">
            <div data-coupon-type="many" class="control-group <?=$form->hasErrors('suffix') ? 'error' : '';?>">
                <?=CHtml::activeLabel($form, 'code');?>
                <?=CHtml::activeTextField($form, 'code');?>
            </div>

            <div class="control-group <?=$form->hasErrors('count') ? 'error' : '';?>">
                <?=CHtml::activeLabel($form, 'count', ['data-coupon-type' => 'solo']);?>
                <?$form->setScenario('many');?>
                <?=CHtml::activeLabel($form, 'count', ['data-coupon-type' => 'many']);?>
                <?=CHtml::activeTextField($form, 'count');?>
            </div>

            <div class="control-group <?=$form->hasErrors('discount') ? 'error' : '';?>">
                <?=CHtml::activeLabel($form, 'discount');?>
                <?=CHtml::activeTextField($form, 'discount');?>
            </div>

            <div class="control-group <?=$form->hasErrors('productIdList') ? 'error' : '';?>">
                <?=CHtml::activeLabel($form, 'productIdList');?>
                <?=CHtml::activeDropDownList($form, 'productIdList', $productDropDown, ['multiple' => true, 'size' => count($products)+1, 'class' => 'span8 m-bottom_0']);?>
                <span class="help-block">Для промо-кодов со скидкой 100% рекомендуется выбирать ровно один тип продукта.</span>
            </div>

            <div class="control-group <?=$form->hasErrors('endTime') ? 'error' : '';?>">
                <?=CHtml::activeLabel($form, 'endTime');?>
                <?=CHtml::activeTextField($form, 'endTime', ['id' => 'endTime']);?>
            </div>

            <div class="control-group">
                <button class="btn btn-success btn-large" type="submit"><i class="icon-ok icon-white"></i> Генерировать</button>
            </div>
        </div>
    </div>


<?=CHtml::endForm();?>