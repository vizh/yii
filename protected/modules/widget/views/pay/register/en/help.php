<?php
/**
 * @var \user\models\User $user
 * @var \pay\models\Product[] $products
 * @var \pay\models\Account $account
 * @var \event\models\Event $event
 * @var int $unpaidOwnerCount
 * @var int $unpaidJuridicalOrderCount
 * @var bool $paidEvent
 */
?>
<div class="alert alert-block alert-muted">
  <p>
    <?if (!empty($user->FirstName)):?>
      Dear <?=$user->getShortName();?>,
    <?else:?>
      Dear customer,
    <?endif;?>
    this step allows you make or edit your order.</p>

  <?if (count($products) > 1):?>
    <p>You can pay both for one or for several participants: all <?=$event->Title;?> services are divided into groups, within which you can specify participants.</p>
  <?else:?>
    <p>You can pay both for one or for several participants.</p>
  <?endif;?>

  <?if (!empty($account->SandBoxUserRegisterUrl)):?>
    <p>
      <strong>If your colleagues have not yet registered for the conference, you can do this on their behalf by <a target="_blank" href="<?=$account->SandBoxUserRegisterUrl;?>">clicking the link</a>.</strong>
    </p>
  <?endif;?>

  <?if (!$account->SandBoxUser):?>
    <p>To add a participant, add his or her Name and Surname or a RUNET-ID, and the system will automatically check if the person is already added as a participant of the event and will offer to add an existing profile, if it is found. Otherwise you will need to fill in the fields with required contact details.</p>

    <?if ($unpaidOwnerCount > 0 || $unpaidJuridicalOrderCount > 0):?>
      <p><strong>Important:</strong> you have already formed but still <a href="<?=$this->getNextStepUrl();?>">unpaid orders</a>.</p>
    <?endif;?>
  <?endif;?>
</div>