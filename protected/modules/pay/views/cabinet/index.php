<?php
/**
 * @var $unpaidItems \pay\models\OrderItem[]
 * @var $finder \pay\components\collection\Finder
 * @var $account \pay\models\Account
 * @var $hasRecentPaidItems bool
 *
 * @var $this \pay\components\Controller
 */
?>


<div class="event-register" data-event-idname="<?=$this->getEvent()->IdName;?>">
  <div class="container">

    <div class="tabs clearfix">
      <div class="tab pull-left">
        <span class="number img-circle">1</span>
        <?=\Yii::t('app', 'Регистрация');?>
      </div>
      <div class="tab current pull-left">
        <span class="number img-circle">2</span>
        <?=\Yii::t('app', 'Оплата');?>
      </div>
    </div>

    <?$this->renderPartial('index/unpaidItems', [
      'unpaidItems' => $unpaidItems,
      'hasRecentPaidItems' => $hasRecentPaidItems,
      'account' => $account,
      'formAdditionalAttributes' => $formAdditionalAttributes
    ]);?>
    <?if (sizeof($finder->getUnpaidOrderCollections()) > 0):?>
      <?$this->renderPartial('index/orders', array('finder' => $finder));?>
    <?endif;?>
  </div>

  <?if (sizeof($finder->getPaidOrderCollections()) > 0 || sizeof($finder->getPaidFreeCollections()) > 0):?>
    <?$this->renderPartial('index/paidItems', [
      'paidCollections' => array_merge($finder->getPaidOrderCollections(), $finder->getPaidFreeCollections())
    ]);?>
  <?endif;?>

</div>
