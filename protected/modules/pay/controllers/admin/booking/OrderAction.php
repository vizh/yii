<?php
namespace pay\controllers\admin\booking;


/**
 * Class OrderAction
 * @property \pay\models\RoomPartnerOrder $order
 * @property \pay\models\forms\admin\PartnerOrder $form
 * @property string $owner
 * @package pay\controllers\admin\booking
 */
class OrderAction extends \CAction
{
  private $form;
  private $order;

  public function run($owner, $orderId = null, $print = null)
  {
    $request = \Yii::app()->getRequest();
    $this->form = new \pay\models\forms\admin\PartnerOrder($owner);
    if ($orderId !== null)
    {
      $this->order = \pay\models\RoomPartnerOrder::model()->byDeleted(false)->findByPk($orderId);
      if ($this->order == null || $this->order->Bookings[0]->Owner != $owner)
        throw new \CHttpException(404);

      if ($print !== null)
      {
        $this->getController()->renderPartial('print', ['order' => $this->order, 'owner' => $owner]);
        \Yii::app()->end();
      }

      $this->form->setAttributes($this->order->getAttributes($this->form->getSafeAttributeNames()));
      $this->form->BookingIdList = \CHtml::listData($this->order->Bookings, 'Id', 'Id');
    }
    else
    {
      $this->order = new \pay\models\RoomPartnerOrder();
      $this->form->BookingIdList = $request->getParam('bookingIdList', []);
    }

    $criteria = new \CDbCriteria();
    $criteria->order = '"t"."Id" ASC';
    $criteria->with = ['Product.Attributes'];
    if ($this->order->Paid)
    {
      $criteria->addCondition('"t"."OrderId" = :OrderId');
      $criteria->params['OrderId'] = $this->order->Id;
    }
    $bookings = \pay\models\RoomPartnerBooking::model()->byOwner($owner)->byDeleted(false)->findAll($criteria);
    if (empty($bookings))
      throw new \CHttpException(404);

    $this->form->attributes = $request->getParam(get_class($this->form));
    if (!$this->order->Paid && $request->getIsPostRequest() && $this->form->validate())
    {
      $this->processForm();
    }

    $this->getController()->setPageTitle(\Yii::t('app', 'Счет на бронирование партнера'));
    $this->getController()->render('order', ['form' => $this->form, 'bookings' => $bookings, 'order' => $this->order]);
  }

  private function processForm()
  {
    foreach($this->form->getAttributes() as $attr => $value)
    {
      if ($this->order->hasAttribute($attr))
      {
        $this->order->$attr = $value;
      }
    }
    $this->order->save();
    foreach ($this->form->BookingIdList as $bookingId)
    {
      $booking = \pay\models\RoomPartnerBooking::model()->findByPk($bookingId);
      $booking->OrderId = $this->order->Id;
      $booking->save();
    }

    \Yii::app()->getUser()->setFlash('success', \Yii::t('app', 'Счет усешно сохранен'));
    $this->getController()->redirect(
      $this->getController()->createUrl('/pay/admin/booking/order', ['owner' => $this->form->getOwner(), 'orderId' => $this->order->Id])
    );
  }
} 