<?php
/**
 * @var \user\models\User $user
 * @var bool $hideContacts
 * @var bool $hideEmployment
 */

$hideEmployment = isset($hideEmployment) && $hideEmployment;
$hideContacts = isset($hideContacts) && $hideContacts;
?>
<?=\CHtml::link('<span class="text-light-gray">' . $user->RunetId . ',</span> ' . $user->getFullName(), ['user/edit', 'id' => $user->RunetId], ['targer' => '_blank', 'class' => 'lead lead-sm']);?>


<?php if (!$hideEmployment && ($employment = $user->getEmploymentPrimary()) !== null):?>
    <p><?=$employment;?></p>
<?php endif;?>

<?php if (!$hideContacts):?>
    <p class="m-top_5 text-nowrap"><i class="fa fa-envelope-o"></i>&nbsp;<?=\CHtml::mailto($user->Email);?>
    <?php if (($phone = $user->getPhone()) !== null):?>
        <br/><i class="fa fa-phone"></i>&nbsp;<?=$phone;?>
    <?php endif;?>
    </p>
<?php endif;?>