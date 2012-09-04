<?php
AutoLoader::Import('library.rocid.pay.*');

class UtilityCsv1 extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    ini_set("memory_limit", "512M");

    $file = fopen('spic.csv', 'w');
    $eventId = 258;
//    $roleId = 30;

    $timestamp = Registry::GetRequestVar('timestamp', 0);
    if ($timestamp != 0)
    {
      $timestamp -= 4*3600 + 15*60;
    }

    $model = EventUser::model()->with(array('User', 'User.Employments' => array('on' => 'Employments.Primary = 1'), 'User.Employments.Company'));
//    $model = EventProgramUserLink::model()->with(array('User', 'User.Employments' => array('on' => 'Employments.Primary = 1'), 'User.Employments.Company'));

    $criteria = new CDbCriteria();
    $criteria->condition = 't.EventId = :EventId AND t.UpdateTime >= :UpdateTime';
//    $criteria->condition = 't.EventId = :EventId AND t.RoleId = :RoleId';
    $criteria->params = array(':EventId' => $eventId, ':UpdateTime' => $timestamp);
//    $criteria->params = array(':EventId' => $eventId, ':RoleId' => $roleId);

    $criteria->group = 't.UserId';
    $criteria->order = 't.CreationTime';

    /** @var $eventUsers EventUser[] */
    $eventUsers = $model->findAll($criteria);

    // Листовки
    $userFlyers = file($_SERVER['DOCUMENT_ROOT'] . '/flyers.csv');

    foreach($eventUsers as $eUser)
    {
			if (empty($eUser->User))
			{
				continue;
			}
      
      $name = @iconv('utf-8', 'Windows-1251', $eUser->User->LastName . ' ' . $eUser->User->FirstName . (!empty($eUser->User->FatherName) ? ' ' . $eUser->User->FatherName : ''));

      $CompanyName = '';
      $Position = '';
      
      if (!empty($eUser->User->Employments))
      {
        $Position = iconv('utf-8', 'Windows-1251', $eUser->User->Employments[0]->Position);
        $CompanyName = @iconv('utf-8', 'Windows-1251', $eUser->User->Employments[0]->Company->Name);
      }

      if ($eUser->EventRole->Name == 'Участник круглого стола') $eUser->EventRole->Name = 'Докладчик';
      $roleName = iconv('utf-8', 'Windows-1251', $eUser->EventRole->Name);
      
      /******** ПИТАНИЕ *******/
      $foodCoffee = '';
      $foodLunch = '';
      $foodBanquet = '';

      // Кофе-брейки
      if (in_array($eUser->EventRole->RoleId, array(3,5,30)))
      {
        $foodCoffee = iconv('utf-8', 'Windows-1251', 'Кофе-брейк');
      }
      // Обеды
      if (in_array($eUser->EventRole->RoleId, array(5,30)))
      {
        $foodLunch = iconv('utf-8', 'Windows-1251', 'Обед');
      }
      // Фуршет
      if ($eUser->EventRole->RoleId != 24)
      {
	      // оплаты
	      $criteria = new CDbCriteria();
	      $criteria->condition = 't.ProductId = :ProductId AND t.Paid = :Paid AND t.OwnerId = :OwnerId';
	      $criteria->params = array(':ProductId' => 689, ':Paid' => 1, ':OwnerId' => $eUser->User->UserId);
	      $orderItem = OrderItem::model()->find($criteria);
	      
	      if ($orderItem != null)
	      {
	      	$foodBanquet = iconv('utf-8', 'Windows-1251', 'Фуршет');
				}
      }

      /***** ПЕЧАТКА *****/
      $arPackages = array('package' => 'Пакет', 'flyer' => '', 'notepad' => '');
      
      // Блокноты
      if (in_array($eUser->EventRole->Name, array('Докладчик', 'Партнёр', 'СМИ', 'Бизнес-участник')))
      {
        $arPackages['notepad'] = 'Блокнот';
      }
      // Листовки
      if (in_array( (int)$eUser->User->RocId, $userFlyers))
      {
        $arPackages['flyer'] = 'Листовка';
      }
      extract($arPackages);

      fputcsv($file, array($eUser->User->RocId, $name, $CompanyName, $roleName, $foodCoffee, $foodLunch, $foodBanquet, iconv('utf-8', 'Windows-1251', $package), iconv('utf-8', 'Windows-1251', $flyer), iconv('utf-8', 'Windows-1251', $notepad), date('d.m.Y H:i:s', $eUser->CreationTime)), ';');
    }
    fclose($file);
    echo 'Готово!';
  }
}
