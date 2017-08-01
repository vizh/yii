<?php
use application\components\utility\Texts;

/**
 * @var $order \pay\models\Order
 * @var $billData array
 * @var $total int
 * @var $nds int
 * @var $withSign bool
 */
?>
<!doctype html>
<html>
<head>
  <title><?=CHtml::encode($this->pageTitle)?></title>
  <meta content="text/html; charset=UTF-8" http-equiv=Content-Type>
</head>
<body>
<div class="content">
  <?=$content?>
  <? $this->renderClip('event-after-payment-code'); ?>
</div>
</body>
</html>