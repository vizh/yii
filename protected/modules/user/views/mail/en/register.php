<?php
/**
 * @var \user\models\User $user
 * @var string $password
 */
?>
<p><strong>Dear <?=$user->FirstName;?> <?=$user->LastName;?></strong>,</p>
<p>You have successfully joined the professional community by registering at <a href="http://runet-id.com/"><strong>RUNET-ID</strong></a>.</p>

<h2>Your Credentials</h2>
<div style="padding: 10px; margin-left: 10px; font-size: 120%; display:inline-block;">
  <div style="margin-bottom: 5px;"><strong>RUNET-ID</strong>: <?=$user->RunetId;?></div>
  <div style="margin-bottom: 5px;"><strong>Password</strong>: <?=$password;?></div>
  <div style="margin-bottom: 5px;"><strong>Email</strong>: <?=$user->Email;?></div>
</div>

<p style="margin-bottom: 80px;">If you have any questions on the operation of the <a href="http://runet-id.com/"><strong>RUNET-ID</strong></a> service, please do not hesitate to contact our support:<br/><a href="mailto:support@runet-id.com">support@runet-id.com</a></p>

<p>Kind regards,<br>
RUNET-ID</p>