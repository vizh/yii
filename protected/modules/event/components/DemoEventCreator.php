<?php
namespace event\components;

/**
 * Class DemoEventCreator
 *
 * Предназначен для генерации демо-мероприятия
 * @package event\components
 */
class DemoEventCreator
{
  // Идентификаторы ролей
  const PARTICIPANT = 1;
  const VIDEO_PARTICIPANT = 26;
  const MASS_MEDIA = 2;
  const PARTNER = 5;

  /**
   * @var string Дата начала продаж
   */
  private static $beginSalesDate;
  private static $dayBeforeChangePriceDate;
  /**
   * @var string Дата изменения цены
   */
  private static $changePriceDate;
  /**
   * @var string Дата начала мероприятия
   */
  private static $eventStartDate;
  /**
   * @var string Дата окончания мероприятия
   */
  private static $eventEndDate;

  private static $dayBeforeEventEndDate;

  /**
   * Генерация демо-мероприятия с участниками
   */
  public static function create()
  {
    self::initDates();

    $transaction = \Yii::app()->db->beginTransaction();
    try
    {
      echo 'Creation event...'."\n";
      $event = self::createDemoEvent();
      echo 'Event has been created'."\n";
      // Участники
      echo 'Creation participants...'."\n";
      $productParticipant = self::createParticipantProduct($event, self::PARTICIPANT, self::$beginSalesDate, 10000, self::$changePriceDate, 15000);
      self::createParticipants($event, $productParticipant, 900);
      echo 'Participants were successfully created'."\n";
      // Видео участники
      echo 'Creation video-participants...'."\n";
      $productVideoParticipant = self::createParticipantProduct($event, self::VIDEO_PARTICIPANT, self::$beginSalesDate, 2000, self::$changePriceDate, 3000);
      self::createParticipants($event, $productVideoParticipant, 150);
      echo 'Video-participants were successfully created'."\n";
      // Партнеры
      echo 'Creation partners...'."\n";
      $product = self::createParticipantProduct($event, self::MASS_MEDIA, self::$beginSalesDate, 0);
      self::createSpecialParticipants($event, $product, 60);
      echo 'Partners were successfully created'."\n";
      // СМИ
      echo 'Creation mass media...'."\n";
      $product = self::createParticipantProduct($event, self::PARTNER, self::$beginSalesDate, 0);
      self::createSpecialParticipants($event, $product, 70);
      echo 'Mass media were successfully created'."\n";
      // Организаторы
      echo 'Creation organizers...'."\n";
      self::createOrganizers($event, 20);
      echo 'Organizers were successfully created'."\n";
      // Промо-коды
      echo 'Creation promos...'."\n";
      self::createPromos($event, $productParticipant, 100);
      self::createPromos($event, $productVideoParticipant, 100);
      echo 'Promos were successfully created'."\n";
      // Операторы
      echo 'Creation operators...'."\n";
      self::createOperators($event, 10);
      echo 'Operators were successfully created'."\n";

      echo 'Randomization dates...'."\n";
      self::randomizeEventParticipantLogDates($event);
      echo 'Dates were successfully randomized'."\n";

      $transaction->commit();
      echo 'Success.';
    }
    catch (\CException $e)
    {
      $transaction->rollback();
      echo 'Error: '.\application\components\utility\Texts::CyrToLat($e->getMessage());
      echo 'Trace: '.$e->getTraceAsString();
    }
  }

  /**
   * Генерирует даты продаж и проведения мероприятия
   */
  protected static function initDates()
  {
    $beginSalesDate = new \DateTime();
    $beginSalesDate->sub(new \DateInterval('P3D'));
    self::$beginSalesDate = $beginSalesDate->format('Y-m-d');
    $changePriceDate = $beginSalesDate->add(new \DateInterval('P2M'));
    self::$changePriceDate = $changePriceDate->format('Y-m-d');
    $dayBeforeChangePriceDate = clone $changePriceDate;
    $dayBeforeChangePriceDate->sub(new \DateInterval('P1D'));
    self::$dayBeforeChangePriceDate = $dayBeforeChangePriceDate->format('Y-m-d');
    $eventStartDate = $changePriceDate->add(new \DateInterval('P2M'));
    self::$eventStartDate = $eventStartDate->format('Y-m-d');
    $eventEndDate = $eventStartDate->add(new \DateInterval('P5D'));
    self::$eventEndDate = $eventEndDate->format('Y-m-d');
    $eventEndDate->sub(new \DateInterval('P1D'));
    self::$dayBeforeEventEndDate = $eventEndDate->format('Y-m-d');
  }

  /**
   * Генерирует мероприятие
   * @return \event\models\Event
   */
  private static function createDemoEvent()
  {
    $startDate = new \DateTime(self::$eventStartDate);
    $endDate = new \DateTime(self::$eventEndDate);

    $event = new \event\models\Event();
    $event->IdName = 'demoevent';
    $event->Title = 'Демо мероприятие';
    $event->Info = 'Это мероприятие предназначено для демонстраций возможностей партнерки.';
    $event->StartYear = $startDate->format('Y');
    $event->StartMonth = $startDate->format('m');
    $event->StartDay = $startDate->format('d');
    $event->EndYear = $endDate->format('Y');
    $event->EndMonth = $endDate->format('m');
    $event->EndDay = $endDate->format('d');
    $event->save();

    $account = new \pay\models\Account();
    $account->EventId = $event->Id;
    $account->OrderTemplateId = 1;
    $account->ReceiptTemplateId = 1;
    $account->save();

    return $event;
  }

  /**
   * Создает продукт - участие в мероприятии
   * @param \event\models\Event $event
   * @param int $roleId
   * @param string $startPriceDate
   * @param int $startPrice
   * @param string $changePriceDate
   * @param int $changedPrice
   * @return \pay\models\Product
   * @throws \CException
   */
  private static function createParticipantProduct(\event\models\Event $event, $roleId, $startPriceDate, $startPrice, $changePriceDate = null, $changedPrice = null)
  {
    // Даты начала и изменения
    $startPriceDate = new \DateTime($startPriceDate);
    $changePriceDate = new \DateTime($changePriceDate);
    $beforeOneDayChangePriceDate = clone $changePriceDate;
    $beforeOneDayChangePriceDate->sub(new \DateInterval('P1D'));

    $role = \event\models\Role::model()->findByPk($roleId);
    if (empty($role))
      throw new \CException('Неизвестный идентификатор роли!');

    $product = new \pay\models\Product();
    $product->ManagerName = 'EventProductManager';
    $product->Title = 'Участие на мероприятии как ' . $role->Title;
    $product->Description = $event->Info;
    $product->EventId = $event->Id;
    $product->Unit = 'шт.';
    $product->EnableCoupon = true;
    $product->save();

    $productAttribute = new \pay\models\ProductAttribute();
    $productAttribute->ProductId = $product->Id;
    $productAttribute->Name = 'RoleId';
    $productAttribute->Value = $roleId;
    $productAttribute->save();

    $productPrice = new \pay\models\ProductPrice();
    $productPrice->ProductId = $product->Id;
    $productPrice->Price = $startPrice;
    $productPrice->StartTime = $startPriceDate->format('Y-m-d');
    $productPrice->EndTime = ($changePriceDate !== null && $changedPrice !== null) ? $beforeOneDayChangePriceDate->format('Y-m-d') : null;
    $productPrice->save();

    if ($changePriceDate !== null && $changedPrice !== null)
    {
      $productPrice = new \pay\models\ProductPrice();
      $productPrice->ProductId = $product->Id;
      $productPrice->Price = $changedPrice;
      $productPrice->StartTime = $changePriceDate->format('Y-m-d');
      $productPrice->EndTime = null;
      $productPrice->save();
    }

    return $product;
  }

  /**
   * @var array Данные для юриков
   */
  private static $juridicalData = [
    'Name' => 'Demo company',
    'Address' => 'г. Москва, Пресненская наб., 12',
    'INN' => '121432543534',
    'KPP' => '436436457357337',
    'Phone' => '+79165654564',
    'PostAddress' => 'г. Москва, Пресненская наб., 12'
  ];

  /**
   * Создает участников
   * @param \event\models\Event $event
   * @param \pay\models\Product $product
   * @param $count
   */
  private static function createParticipants(\event\models\Event $event, \pay\models\Product $product, $count)
  {
    $index = 0;
    while ($count > 0)
    {
      $users = [];
      for ($i = 0; $i < rand(1, 3); ++$i)
      {
        $users[] = self::createUser(rand(0, 1));
        --$count;
        echo ++$index."\n";
      }

      // Печать бейджей
      if ($product->getManager()->RoleId != self::VIDEO_PARTICIPANT)
      {
        foreach ($users as $user)
          self::printBadge($event, $user, $product->getManager()->RoleId);
      }

      $product->getManager()->createOrderItem($users[0], $users[0]);
      if (count($users) > 1)
        $product->getManager()->createOrderItem($users[0], $users[1]);
      if (count($users) > 2)
        $product->getManager()->createOrderItem($users[0], $users[2]);

      // Прямое проставление статуса
      if (!mt_rand(0, 19))
      {
        foreach ($users as $user)
        {
          $eventParticipant = new \event\models\Participant();
          $eventParticipant->EventId = $event->Id;
          $eventParticipant->UserId = $user->Id;
          $eventParticipant->RoleId = $product->getManager()->RoleId;
          $eventParticipant->save();
        }
        continue;
      }

      // 100% промо-код
      if (!mt_rand(0, 9))
      {
        $coupon = new \pay\models\Coupon();
        $coupon->EventId = $event->Id;
        $coupon->Discount = 1.00;
        $coupon->Code = $coupon->generateCode();
        $coupon->save();
          $coupon->addProductLinks([$product]);

        foreach ($users as $user)
          $coupon->activate($user, $user);

        continue;
      }

      // Оплата
      $order = new \pay\models\Order();
      if (!mt_rand(0, 2))
        $order->CreationTime = self::generateRandomDate(self::$beginSalesDate, self::$dayBeforeChangePriceDate);
      else
        $order->CreationTime = self::generateRandomDate(self::$changePriceDate, self::$dayBeforeEventEndDate);

      $order->create($users[0], $event, rand(1, 3), self::$juridicalData);

      // Некоторым активируем скидки
      if (!mt_rand(0, 2))
      {
        $coupon = new \pay\models\Coupon();
        $coupon->EventId = $event->Id;
        $coupon->Discount = mt_rand(0, 1) ? 0.1 : 0.25;
        $coupon->Code = $coupon->generateCode();
        $coupon->save();
          $coupon->addProductLinks([$product]);

        foreach ($users as $user)
          $coupon->activate($user, $user);
      }
      $order->activate();
    }
  }

  /**
   * Регистрация Партнеров и СМИ
   * @param \event\models\Event $event
   * @param \pay\models\Product $product
   * @param $count
   */
  private static function createSpecialParticipants(\event\models\Event $event, \pay\models\Product $product, $count)
  {
    $index = 0;
    while ($count-- > 0)
    {
      $user = self::createUser(rand(0, 1));

      // Прямое проставление статуса
      if (!mt_rand(0, 9))
      {
        $eventParticipant = new \event\models\Participant();
        $eventParticipant->EventId = $event->Id;
        $eventParticipant->UserId = $user->Id;
        $eventParticipant->RoleId = $product->getManager()->RoleId;
        $eventParticipant->save();
        continue;
      }

      // 100% промо-код
      $coupon = new \pay\models\Coupon();
      $coupon->EventId = $event->Id;
      $coupon->Discount = 1.00;
      $coupon->Code = $coupon->generateCode();
      $coupon->save();
        $coupon->addProductLinks([$product]);
      $coupon->activate($user, $user);
      echo ++$index."\n";
    }
  }

  /**
   * Создает организаторов
   * @param \event\models\Event $event
   * @param $count
   */
  private static function createOrganizers(\event\models\Event $event, $count)
  {
    $index = 0;
    while ($count-- > 0)
    {
      $user = self::createUser(rand(0, 1));

      $eventParticipant = new \event\models\Participant();
      $eventParticipant->EventId = $event->Id;
      $eventParticipant->UserId = $user->Id;
      $eventParticipant->RoleId = 6 /* Организатор */;
      $eventParticipant->save();
      echo ++$index."\n";
    }
  }

  /**
   * Генерируем промо-коды
   * @param \event\models\Event $event
   * @param \pay\models\Product $product
   * @param $count
   */
  private static function createPromos(\event\models\Event $event, \pay\models\Product $product, $count)
  {
    $index = 0;
    while ($count-- > 0)
    {
      $coupon = new \pay\models\Coupon();
      $coupon->EventId = $event->Id;
      $coupon->Discount = mt_rand(0, 1) ? (mt_rand(0, 1) ? 0.1 : 0.25) : 0.1;
      $coupon->Code = $coupon->generateCode();
      $coupon->save();
        $coupon->addProductLinks([$product]);
      echo ++$index."\n";
    }
  }

  /**
   * Генерирует операторов
   * @param \event\models\Event $event
   * @param $count
   */
  private static function createOperators(\event\models\Event $event, $count)
  {
    $index = 0;
    while ($count-- > 0)
    {
      $operator = new \ruvents\models\Operator();
      $operator->EventId = $event->Id;
      $email = self::generateEmail();
      $operator->Login = $email;
      $operator->Password = $email;
      $operator->Role = 'Operator';
      $operator->save();
      echo ++$index."\n";
    }
  }

  /**
   * Рандомихирует даты CreationTime в ParticipantLog
   * @param \event\models\Event $event
   */
  private static function randomizeEventParticipantLogDates(\event\models\Event $event)
  {
    $participants = \event\models\Participant::model()->findAll('"EventId" = :eventId', [':eventId' => $event->Id]);
    foreach ($$participants as $participant)
    {
      $participant->CreationTime = self::generateRandomDate(self::$beginSalesDate, self::$eventStartDate);
      $participant->save();
    }

    $logs = \event\models\ParticipantLog::model()->findAll('"EventId" = :eventId', [':eventId' => $event->Id]);
    foreach ($logs as $log)
    {
      $log->CreationTime = self::generateRandomDate(self::$beginSalesDate, self::$eventStartDate);
      $log->save();

      $participant = \event\models\Participant::model()->find(
        '"EventId" = :eventId AND "UserId" = :userId',
        [':eventId' => $log->EventId, ':userId' => $log->UserId]
      );
      $participant->CreationTime = $log->CreationTime;
      $participant->save();
    }
  }


  /**
   * Печатает заданное количество бейджей
   * @param \event\models\Event $event
   * @param \user\models\User $user
   * @param $roleId
   */
  private static function printBadge(\event\models\Event $event, \user\models\User $user, $roleId)
  {
    $creationTime = new \DateTime(self::generateRandomTime(self::$eventStartDate, self::$eventEndDate));
    $count = 1;
    if (!mt_rand(0, 6))
    {
      $count = 2;
      if (!mt_rand(0, 1))
        $count = 3;
    }

    for ($i = 0; $i < $count; ++$i)
    {
      $badge = new \ruvents\models\Badge();
      $badge->EventId = $event->Id;
      $badge->UserId = $user->Id;
      $badge->RoleId = $roleId;
      $badge->CreationTime = $creationTime->format('Y-m-d H:i:s');
      $creationTime->add(new \DateInterval('P1D'));
    }
  }

  /**
   * Создает пользователя
   * @param bool $needPhone
   * @return \user\models\User
   */
  private static function createUser($needPhone = false)
  {
    $genders = ['male', 'female'];
    $user = new \user\models\User();
    $user->Email = self::generateEmail();
    $user->Gender = $genders[rand(0, 1)];
    self::setRandomUserName($user, $user->Gender);
    $user->Birthday = date('Y-m-d', rand(0, 820454400));
    $user->Visible = false;
    $user->Temporary = true;
    $user->register(false);

    self::setRandomCompany($user);
    if ($needPhone)
      $user->setContactPhone('+7'.rand(9001110000, 9999999999));

    return $user;
  }

  /**
   * Устанавливает случайное имя пользователю имя пользователю
   * @param \user\models\User $user
   * @param $gender
   */
  private static function setRandomUserName(\user\models\User $user, $gender)
  {
    $names = \Yii::app()->db->createCommand(
      'WITH "Names" AS ('.
      'SELECT "LastName", "FirstName", "FatherName", 1 AS "g" FROM "User" "t" WHERE "Gender" = \''.$gender.'\' ORDER BY RANDOM() LIMIT 3'.
      ') SELECT (ARRAY_AGG("LastName"))[1] AS "LastName", (ARRAY_AGG("FirstName"))[2] AS "FirstName", (ARRAY_AGG("FatherName"))[3] AS "FatherName" FROM "Names" GROUP BY "g"'
    )->queryRow();
    $user->LastName = $names['LastName'];
    $user->FirstName = $names['FirstName'];
    $user->FatherName = $names['FatherName'];
  }

  /**
   * Устанавливает случайное место работы пользователю
   * @param \user\models\User $user
   */
  private static function setRandomCompany(\user\models\User $user)
  {
    do
    {
      $employment = \user\models\Employment::model()->find([
        'order' => 'RANDOM()',
        'limit' => 1,
        'with' => [
          'Company'
        ]
      ]);
    }
    while (empty($employment->Company->Name));
    $user->setEmployment($employment->Company->Name, $employment->Position);
  }

  /**
   * Генерирует случайный email
   * @param int $minLength
   * @param int $maxLength
   * @return string
   */
  private static function generateEmail($minLength = 4, $maxLength = 10)
  {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ123456789';
    $numChars = rand($minLength, $maxLength);
    $mail = '';
    for ($i = 0; $i < $numChars; $i++)
      $mail .= substr($chars, rand(1, $numChars) - 1, 1);

    return $mail.'@demoevt.ru';
  }

  /**
   * Генерирует случайную дату
   * @param string $startDate
   * @param string $endDate
   * @return string
   */
  private static function generateRandomDate($startDate, $endDate)
  {
    $startDate = new \DateTime($startDate);
    $endDate = new \DateTime($endDate);
    return date('Y-m-d', mt_rand($startDate->format('U'), $endDate->format('U')));
  }

  /**
   * Генерирует случайную дату и время
   * @param string $startDate
   * @param string $endDate
   * @return string
   */
  private static function generateRandomTime($startDate, $endDate)
  {
    $startDate = new \DateTime($startDate);
    $endDate = new \DateTime($endDate);
    return date('Y-m-d H:i:s', mt_rand($startDate->format('U'), $endDate->format('U')));
  }
} 