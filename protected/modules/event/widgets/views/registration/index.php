<?php
/**
 * @var \event\widgets\Registration $this
 * @var \pay\models\Product[] $products
 * @var \pay\models\Account $account
 * @var \event\models\Participant $participant
 * @var array $productsByGroup
 * @var bool $paidEvent
 */
if (empty($products))
    return;
?>
<?=CHtml::beginForm(Yii::app()->createUrl('/pay/cabinet/register', ['eventIdName' => $this->event->IdName]), 'post', ['class' => 'registration event-registration']);?>
<?=CHtml::hiddenField(Yii::app()->getRequest()->csrfTokenName, Yii::app()->getRequest()->getCsrfToken()); ?>

<?php $this->render('registration/participant', ['participant' => $participant]);?>


    <table class="table table-condensed">
        <thead>
        <tr>
            <th></th>
            <th class="t-right col-width"><?=Yii::t('app', 'Цена');?></th>
            <th class="t-center col-width"><?=Yii::t('app', 'Кол-во');?></th>
            <th class="t-right col-width"><?=Yii::t('app', 'Сумма');?></th>
        </tr>
        </thead>
        <tbody>

        <?php foreach ($productsByGroup as $groupName => $value):?>
            <?php if (!is_array($value)):?>
                <?php $this->render('registration/product', ['product' => $value]);?>
            <?php else:?>
                <tr>
                    <td colspan="4">
                        <article>
                            <h4 class="article-title"><?=$groupName;?></h4>
                        </article>
                    </td>
                </tr>
                <?php foreach ($value as $product):?>
                    <?php $this->render('registration/product', ['product' => $product, 'groupProduct' => true]);?>
                <?php endforeach;?>
            <?php endif;?>
        <?php endforeach;?>

        <tr>
            <td colspan="4" class="t-right total">
                <span><?=Yii::t('app', 'Итого');?>:</span> <b id="total-price" class="number">0</b> <?=Yii::t('app', 'руб.');?>
            </td>
        </tr>
        </tbody>
    </table>

<?php $this->render('registration/footer', ['participant' => $participant, 'paidEvent' => $paidEvent]);?>

<?=CHtml::endForm();?>