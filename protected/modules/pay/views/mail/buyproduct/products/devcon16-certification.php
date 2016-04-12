<?php
use event\models\UserData;

/**
 * @var \user\models\User $user
 * @var string $code
 * @var \event\models\Event $event
 */

$definitions = UserData::getDefinedAttributeValues($event, $user);
?>
<p style="font-family: Segoe UI, Tahoma,Arial,Helvetica, sans-serif; font-size: 14px;">Вы успешно зарегистрировались на
    экзамен на официальную сертификацию Microsoft.</p>

<p>
    <strong>Дата экзамена:</strong> <?=\Yii::app()->getDateFormatter()->format('dd MMMM yyyy', $definitions['CertificationDate']);?><br/>
    <strong>Время экзамен:</strong> <?=$definitions['CertificationTime'];?><br/>
    <strong>Выбранный экзамен:</strong> <?=$definitions['CertificationExamTitle'];?>
</p>


