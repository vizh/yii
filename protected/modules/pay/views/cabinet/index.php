<?php
/**
 * @var $unpaidItems \pay\models\OrderItem[]
 * @var $paidItems \pay\models\OrderItem[]
 * @var $recentPaidItems \pay\models\OrderItem[]
 * @var $orders \pay\models\Order[]
 *
 * @var $this \pay\components\Controller
 */

$paidItems = array_merge($recentPaidItems, $paidItems);
?>


<div class="event-register" data-event-idname="<?=$this->getEvent()->IdName;?>">
  <div class="container">

    <div class="tabs clearfix">
      <div class="tab pull-left">
        <span class="number img-circle">1</span>
        <?=\Yii::t('pay', 'Регистрация');?>
      </div>
      <div class="tab current pull-left">
        <span class="number img-circle">2</span>
        <?=\Yii::t('pay', 'Оплата');?>
      </div>
    </div>

    <?$this->renderPartial('index/unpaidItems', array('unpaidItems' => $unpaidItems, 'hasRecentPaidItems' => (sizeof($recentPaidItems) > 0)));?>

    <?php if (sizeof($orders) > 0):?>
      <?$this->renderPartial('index/orders', array('orders' => $orders));?>
    <?php endif;?>
  </div>

  <?if (sizeof($paidItems) > 0):?>
    <?$this->renderPartial('index/paidItems', array('paidItems' => $paidItems));?>
  <?endif;?>

</div>
