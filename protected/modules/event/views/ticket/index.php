<?php
/**
 * @var \event\models\Event $event
 * @var \event\models\Role $role
 * @var \user\models\User $user
 * @var \pay\models\OrderItem[] $orderItems
 */
?>
<div style="width: 500px; margin: 100px auto 0">
  <img src="<?=\ruvents\components\QrCode::getAbsoluteUrl($user, 500);?>"/>
</div>