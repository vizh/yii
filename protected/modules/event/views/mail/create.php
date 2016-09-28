<?
/**
 * @var Create $form
 * @var Event $event
 */

use \event\models\forms\Create;
use event\models\Event;
?>

Контактное лицо: <?=$form->ContactName?>

Контактный телефон: <?=$form->ContactPhone?>

Контактный email: <?=$form->ContactEmail?>

Название мероприятия: <?=$form->Title?>

Место проведения: <?=$form->City?>, <?=$form->Place?>

Дата: от <?=$form->StartDate?> до <?=$form->EndDate?>

Сайт мероприятия: <?=$form->Url?>



Краткое описание: <?=$form->Info?>

Подробное описание: <?=$form->FullInfo?>


Дополнительные опции:
<?foreach($form->Options as $option):?>
  <?=$form->getOptionValue($option)?>

<?endforeach?>


Вакансию отправил: <?=\Yii::app()->user->getCurrentUser()->getFullName()?> (RUNET-ID: <?=\Yii::app()->user->getCurrentUser()->RunetId?>)