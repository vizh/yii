<?php
/**
 * @var \widget\components\Controller $this
 * @var \pay\models\Order $order
 * @var system $system
 */
?>
<div class="alert alert-success">
    <?if($system == 'juridical'):?>
        <?=\Yii::t('app', 'Счет успешно сформирован. Для его просмотра перейдите по')?> <?=\CHtml::link(\Yii::t('app', 'cсылке'), $order->getUrl(), ['target' => '_blank'])?>.
    <?php else:?>
        <?=\Yii::t('app', 'Спасибо, заказ оплачен!<br/>Подробная информация отправлена на ваш электронный адрес')?>.
    <?endif?>
</div>
