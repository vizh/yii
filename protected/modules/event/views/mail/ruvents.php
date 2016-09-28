При добаление мероприятия пользователь выбрал оффлайн регистрацию.

Контактное лицо: <?=$form->ContactName?>

Контактный телефон: <?=$form->ContactPhone?>

Контактный email: <?=$form->ContactEmail?>

Название мероприятия: <?=$form->Title?>

Место проведения: <?=$form->Place?>

Дата: от <?=$form->StartDate?> до <?=$form->EndDate?>

Сайт мероприятия: <?=$form->Url?>

Вакансию отправил: <?=\Yii::app()->user->getCurrentUser()->getFullName()?> (RUNET-ID: <?=\Yii::app()->user->getCurrentUser()->RunetId?>)