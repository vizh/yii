<?php
/**
 * @var \user\models\User $user
 * @var \event\models\Role $role
 */

$vip = \pay\models\OrderItem::model()->byAnyOwnerId($user->Id)->byProductId(3080)->exists();
$path = \Yii::getPathOfAlias('webroot.img.ticket.premiaru14.tickets.'.$user->Id.'_'.$role->Id.'_'.($vip ? '1' : '0')).'.jpg';
if (!file_exists($path)) {
    $bg = \Yii::getPathOfAlias('webroot.img.ticket.premiaru14.bg').'.jpg';
    /** @var Image $ticket */
    $ticket = \Yii::app()->image->load($bg);

    $text = $user->RunetId;
    $len = strlen($text);
    if ($len < 6) {
        $text = str_pad($text, 6, '0', STR_PAD_LEFT);
    }

    $x = 588;
    if ($vip) {
        $text = 'V'.$text;
        $x = $x - 18;
    }

    $ticket->text($text, 22, $x, 668, [198,162,205]);

    $qrPath = str_replace('http://runet-id.com', \Yii::getPathOfAlias('webroot'), \ruvents\components\QrCode::getAbsoluteUrl($user, 90));
    $qr = \Yii::app()->image->load($qrPath);
    $ticket->insert($qr, 588, 540);
    $ticket->save($path);
}
?>
<style type="text/css">
    body {
        background-color: #12110c;
    }
</style>
<img src="<?=str_replace(\Yii::getPathOfAlias('webroot'), '', $path)?>" border="0" />