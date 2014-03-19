<?php
namespace pay\controllers\admin\booking;

class StatisticsAction extends \CAction
{
  const EventId = 789;
  const ManagerName = 'RoomProductManager';

  private $event;

  public function run()
  {
    $this->event = \event\models\Event::model()->findByPk(self::EventId);
    $statistics = $this->getStatisticsArray();

    $criteria = new \CDbCriteria();
    $criteria->with = ['Product'];
    $criteria->addCondition('"Product"."EventId" = :EventId AND "Product"."ManagerName" = :Manager');
    $criteria->params['EventId'] = self::EventId;
    $criteria->params['Manager'] = self::ManagerName;
    $orderItems = \pay\models\OrderItem::model()->byDeleted(false)->findAll($criteria);

    $allCount = $this->getAllNumberCount();
    foreach ($orderItems as $orderItem)
    {
      $datetime = new \DateTime($orderItem->getItemAttribute('DateIn'));
      while ($datetime->format('Y-m-d') <  $orderItem->getItemAttribute('DateOut'))
      {
        $key = $datetime->format('d').'-';
        $datetime->modify('+1 day');
        $key .= $datetime->format('d');
        if ($orderItem->Paid)
        {
          $statistics->Numbers[$key]->Paid++;
          $statistics->TotalPaidPrice += $orderItem->getPriceDiscount();
        }
        else
        {
          $statistics->Numbers[$key]->Booking++;
          $statistics->TotalBookPrice += $orderItem->getPriceDiscount();
        }

        $statistics->Numbers[$key]->Free = $allCount - ($statistics->Numbers[$key]->Booking + $statistics->Numbers[$key]->Paid);
      }
    }

    $this->getController()->setPageTitle(\Yii::t('app', 'Статистика бронирования'));
    $this->getController()->render('statistics', ['statistics' => $statistics]);
  }


  private function getStatisticsArray()
  {
    $statistics = new \stdClass();
    $statistics->TotalPaidPrice = 0;
    $statistics->TotalBookPrice = 0;
    $statistics->Numbers = [];

    $datetime = new \DateTime();
    $datetime->setTimestamp($this->event->getTimeStampStartDate());
    $datetime->modify('-1 day');
    while ($datetime->getTimestamp() < $this->event->getTimeStampEndDate())
    {
      $from = $datetime->format('Y-m-d');
      $key = $datetime->format('d').'-';
      $datetime->modify('+1 day');
      $key .= $datetime->format('d');

      $statistics->Numbers[$key] = new \stdClass();
      $statistics->Numbers[$key]->DateFrom = $from;
      $statistics->Numbers[$key]->DateTo = $datetime->format('Y-m-d');
      $statistics->Numbers[$key]->Paid = 0;
      $statistics->Numbers[$key]->Booking = 0;
      $statistics->Numbers[$key]->Free = 0;
    }
    return $statistics;
  }

  private function getAllNumberCount()
  {
    $criteria = new \CDbCriteria();
    $criteria->with = ['Attributes'];
    $criteria->addCondition('"Attributes"."Name" = \'Visible\' AND "Attributes"."Value" = \'1\'');
    return \pay\models\Product::model()->byEventId(self::EventId)->byManagerName(self::ManagerName)->count($criteria);
  }
} 