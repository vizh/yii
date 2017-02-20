<?php
/**
 * @var PayButtons $this
 */

use pay\widgets\PayButtons;
?>
<div id="pay_widget_PayButtons">
    <h5><?=\Yii::t('app', 'Для физических лиц')?></h5>
    <ul class="clearfix">
        <?foreach($this->getSystemButtons() as $name):?>
            <li><?$this->renderButton($name)?></li>
        <?endforeach?>
    </ul>

    <ul class="clearfix">
        <?foreach($this->getPayButtons() as $name):?>
            <li><?$this->renderButton(in_array($name, PayButtons::$OnlineMoney) ? 'onlinemoney' : $name, $name)?></li>
        <?endforeach?>
    </ul>

    <?if($this->enableReceipt()):?>
        <ul class="clearfix">
            <li><?$this->renderButton('receipt')?></li>
        </ul>
    <?endif?>
</div>
