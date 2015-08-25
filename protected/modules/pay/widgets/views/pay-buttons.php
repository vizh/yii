<?php
/**
 * @var PayButtons $this
 */

use pay\widgets\PayButtons;
?>
<div id="pay_widget_PayButtons">
    <h5><?=\Yii::t('app', 'Для физических лиц');?></h5>
    <ul>
        <?php foreach ($this->getSytemButtons() as $name):?>
            <li><?php $this->renderButton($name);?></li>
        <?php endforeach;?>
    </ul>

    <h5><?=\Yii::t('app', 'Электронные деньги');?></h5>
    <ul class="online-money">
        <?php foreach ($this->getPayButtons() as $name):?>
            <li><?php $this->renderButton(in_array($name, PayButtons::$OnlineMoney) ? 'onlinemoney' : $name, $name);?></li>
        <?php endforeach;?>
    </ul>
</div>
