<?php
/**
 * @var UserVerify $this
 * @var \user\models\User $user
 */

use \application\widgets\alerts\UserVerify;
?>
<div class="alert alert-warning" id="<?=$this->getNameId()?>">
    <div class="container">
        <?=\Yii::t('app', 'Пожалуйста, подтвердите Ваш аккаунт для того, что бы мы могли отправлять билеты и информацию по мероприятиям, в которых Вы участвуете или будете участвовать.')?>
        <?=\CHtml::link(\Yii::t('app', 'Отправить подтверждение'), '#')?>.
        <div class="hide">
            <?=\Yii::t('app', 'На e-mail <strong>{email}</strong> отправлено письмо, перейдите по ссылке из письма для подтверждение профиля.', ['{email}' => $user->Email])?>
        </div>
    </div>
</div>
