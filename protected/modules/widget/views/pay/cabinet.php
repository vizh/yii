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
<div class="cabinet" data-event-idname="<?=$this->getEvent()->IdName;?>">
  <?$this->renderPartial('cabinet/unpaidItems', [
    'unpaidItems' => $unpaidItems,
    'hasRecentPaidItems' => $hasRecentPaidItems,
    'account' => $account,
    'formAdditionalAttributes' => $formAdditionalAttributes
  ]);?>
  <?if (sizeof($finder->getUnpaidOrderCollections()) > 0):?>
    <?$this->renderPartial('cabinet/orders', array('finder' => $finder));?>
  <?endif;?>

  <?if (sizeof($finder->getPaidOrderCollections()) > 0 || sizeof($finder->getPaidFreeCollections()) > 0):?>
    <?$this->renderPartial('cabinet/paidItems', [
      'paidCollections' => array_merge($finder->getPaidOrderCollections(), $finder->getPaidFreeCollections())
    ]);?>
  <?endif;?>

</div>
