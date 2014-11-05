<?php
/**
 * @var \user\models\User $user
 * @var Role $role
 */


$path = \Yii::getPathOfAlias('webroot.img.ticket.vilikeshow14.tickets.'.$user->Id.'_'.$role->Id).'.png';
if (!file_exists($path)) {
    if ($role->Id == 14) {
        $bgName = 2;
        $color  = [255,255,255];
    } else {
        $bgName = 1;
        $color  = [111,10,121];
    }

    $bg = \Yii::getPathOfAlias('webroot.img.ticket.vilikeshow14.'.$bgName).'.jpg';
    $ticket = \Yii::app()->image->load($bg);
    $ticket->text($user->getFullName(), 25, 35, 377, $color);
    $qrPath = str_replace('http://runet-id.com', \Yii::getPathOfAlias('webroot'), \ruvents\components\QrCode::getAbsoluteUrl($user, 120));
    $qr = \Yii::app()->image->load($qrPath);
    $ticket->insert($qr, 540, 305);
    $ticket->save($path);
}
?>
<img src="<?=str_replace(\Yii::getPathOfAlias('webroot'), '', $path)?>" border="0" />