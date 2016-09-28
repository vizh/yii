<?php
/**
 * @var user\models\User $user
 * @var string $code
 * @var event\models\Event $event
 */

use event\models\UserData;

$definitions = UserData::getDefinedAttributeValues($event, $user);

$pos = strrpos($definitions['CertificationExamId'], '_');
$examId = substr($definitions['CertificationExamId'], 0, $pos !== false ? $pos : strlen($definitions['CertificationExamId']));
?>
<p style="font-family: Segoe UI, Tahoma,Arial,Helvetica, sans-serif; font-size: 14px;">Вы успешно зарегистрировались на
    экзамен на официальную сертификацию Microsoft.</p>

<p>
    <strong>Дата экзамена:</strong> <?=\Yii::app()->getDateFormatter()->format('dd MMMM yyyy', $definitions['CertificationDate'])?><br/>
    <strong>Время экзамена:</strong> <?=$definitions['CertificationTime']?><br/>
    <strong>Выбранный экзамен:</strong>  <a href="https://www.microsoft.com/ru-ru/learning/exam-<?=$examId?>.aspx"><?=$definitions['CertificationExamTitle']?></a>
</p>

<p>Сертификация будет проходить в Главном корпусе природного курорта "Клязьма" на 1 этажа.</p>

