<?php
/**
 * @var $user \user\models\User
 */
?>
<p><strong>Dear Customer</strong>,</p>
<p>You have successfully registered a temporary account at <a href="http://runet-id.com/"><strong>RUNET-ID</strong></a>.</p>

<h2>Here is the link for your any-time authorization:</h2>
<div style="padding: 10px; margin-left: 10px; font-size: 120%; display:inline-block;">
  <div style="margin-bottom: 5px;"><a href="<?=$user->getFastauthUrl(isset(\Yii::app()->params['TemporaryUserRedirect']) ? \Yii::app()->params['TemporaryUserRedirect'] : '');?>">Payment Profile</a></div>
</div>


<p style="margin-bottom: 80px;">If you have any questions on the operation of the <a href="http://runet-id.com/"><strong>RUNET-ID</strong></a> service, please do not hesitate to contact our support:<br/><a href="mailto:support@runet-id.com">support@runet-id.com</a></p>

<p>Kind regards,<br>
  RUNET-ID</p>