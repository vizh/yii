<?php
namespace pay\controllers\admin\booking;

use pay\models\RoomPartnerBooking;
use pay\components\admin\Rif;
use event\models\Participant;
use pay\models\OrderItem;
use user\models\User;
use pay\models\TmpRifParking;

use \pay\models\forms\admin\TmpRifParking as TmpRifParkingForm;

/**
 * Class ParkingAction
 * @package pay\controllers\admin\booking
 * @property \pay\models\forms\admin\TmpRifParking $form
 * @property ParkingItem[] $parking
 */
class ParkingAction extends \CAction
{
  private $parking;
  private $form;

  public function run()
  {
    $this->initPartner();
    $this->initParticipants();
    $this->initLocalTable();

    $this->form = new TmpRifParkingForm();

    $this->processAjaxAction();

    $this->getController()->setPageTitle(\Yii::t('app', 'Парковка'));
    $this->getController()->render('parking', ['parking' => $this->parking, 'form' => $this->form]);
  }

  private function initPartner()
  {
    $bookings = RoomPartnerBooking::model()->byEventId(\Yii::app()->params['AdminBookingEventId'])->findAll();
    /** @var \pay\models\RoomPartnerBooking $booking */
    foreach ($bookings as $booking)
    {
      $car = json_decode($booking->Car);
      if ($car !== null && !empty($car->Number))
      {
        $manager = $booking->Product->getManager();

        $item = new ParkingItem();
        $item->Number = $car->Number;
        $item->Brand  = $car->Brand;
        $item->Model  = $car->Model;
        $item->Status = ParkingItem::STATUS_PARTNER;
        $item->Hotel  = $manager->Hotel;
        $item->Dates  = $this->getDateList($booking->DateIn, $booking->DateOut);
        $this->parking[] = $item;
      }
    }
  }

  private function initParticipants()
  {
    $command = Rif::getDb()->createCommand();
    $command->select('*')->from('ext_booked_parking')->order('id ASC');
    $result = $command->queryAll();
    foreach ($result as $row)
    {
      $user = User::model()->byRunetId($row['ownerRunetId'])->find();
      if ($user !== null)
      {
        $item = new ParkingItem();
        $item->Number = $row['carNumber'];
        $item->Brand  = $row['brand'];
        $item->Model  = $row['model'];

        $participant = Participant::model()->byUserId($user->Id)->byEventId(\Yii::app()->params['AdminBookingEventId'])->find();
        if ($participant == null)
          continue;

        if ($participant->RoleId == 3)
        {
          $item->Status = ParkingItem::STATUS_REPORTER;
          $item->Dates  = $this->getDateList(date('Y').'-04-13', date('Y').'-04-15');
          $item->Hotel  = Rif::HOTEL_LD;
        }
        else
        {
          $criteria = new \CDbCriteria();
          $criteria->addCondition('"Product"."ManagerName" = :ManagerName');
          $criteria->params['ManagerName'] = 'RoomProductManager';
          $orderItem = OrderItem::model()->byEventId(\Yii::app()->params['AdminBookingEventId'])->byPaid(true)->byAnyOwnerId($user->Id)->find($criteria);
          if ($orderItem == null)
            continue;

          $manager = $orderItem->Product->getManager();
          $item->Hotel  = $manager->Hotel;
          $item->Status = ParkingItem::STATUS_PARTICIPANT;
          $item->Dates  = $this->getDateList($orderItem->getItemAttribute('DateIn'), $orderItem->getItemAttribute('DateOut'));
        }
        $this->parking[] = $item;
      }
    }
  }

  private function initLocalTable()
  {
    $parking = TmpRifParking::model()->byEventId(\Yii::app()->params['AdminBookingEventId'])->findAll();
    /** @var \pay\models\TmpRifParking $model */
    foreach ($parking as $model)
    {
      $item = new ParkingItem();
      foreach ($model->getAttributes() as $name => $value)
      {
        if (property_exists($item, $name))
          $item->$name = $value;
      }
      $item->Dates = $this->getDateList($model->DateIn, $model->DateOut);
      $this->parking[] = $item;
    }
  }

  private function processAjaxAction()
  {
    $request = \Yii::app()->getRequest();
    $action = $request->getParam('action');
    if ($request->getIsAjaxRequest() && $action !== null)
    {
      $method = 'processAjaxAction'.ucfirst($action);
      if (method_exists($this, $method))
      {
        $result = $this->$method();
      }
      echo json_encode($result);
      \Yii::app()->end();
    }
  }

  /**
   *
   */
  private function processAjaxActionAddParking()
  {
    $result = new \stdClass();
    $request = \Yii::app()->getRequest();
    $this->form->attributes = $request->getParam(get_class($this->form));
    if ($this->form->validate())
    {
      $parking = new TmpRifParking();
      $parking->Brand   = $this->form->Brand;
      $parking->Model   = $this->form->Model;
      $parking->Number  = $this->form->Number;
      $parking->Hotel   = $this->form->Hotel;
      $parking->DateIn  = \Yii::app()->getDateFormatter()->format('yyyy-MM-dd', $this->form->DateIn);
      $parking->DateOut = \Yii::app()->getDateFormatter()->format('yyyy-MM-dd', $this->form->DateOut);
      $parking->Status  = $this->form->Status;
      $parking->EventId  = \Yii::app()->params['AdminBookingEventId'];
      $parking->save();
      $result->success = true;
    }
    else
    {
      $result->errors = $this->form->getErrors();
    }
    return $result;
  }



  private function getDateList($dateIn, $dateOut)
  {
    $result = [];
    $datetime = new \DateTime($dateIn);
    while ($datetime->format('Y-m-d') <= $dateOut)
    {
      $result[] = \Yii::app()->getDateFormatter()->format('dd MMMM yyyy', $datetime->getTimestamp());
      $datetime->modify('+1 day');
    }
    return $result;
  }
}

class ParkingItem
{
  const STATUS_PARTNER = 'partner';
  const STATUS_PARTICIPANT = 'participant';
  const STATUS_REPORTER = 'reporter';
  const STATUS_ORGANIZER = 'organizer';
  const STATUS_VIP = 'vip';
  const STATUS_TV = 'tv';

  public $Number;
  public $Brand;
  public $Model;
  public $Status;
  public $Hotel;
  public $Dates = [];
  public $EventId;

  public static function getStatusTitleList()
  {
    return [
      self::STATUS_PARTICIPANT => \Yii::t('app', 'Участник'),
      self::STATUS_PARTNER => \Yii::t('app', 'Партнер'),
      self::STATUS_REPORTER => \Yii::t('app', 'Докладчик'),
      self::STATUS_ORGANIZER => \Yii::t('app', 'Организатор'),
      self::STATUS_VIP => \Yii::t('app', 'VIP'),
      self::STATUS_TV => \Yii::t('app', 'Телеканал')
    ];
  }

  public function getStatusTitle()
  {
    $status = $this->Status == self::STATUS_PARTNER ? self::STATUS_PARTICIPANT : $this->Status;
    return self::getStatusTitleList()[$status];
  }
}
