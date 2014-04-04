<?php
namespace pay\controllers\admin\booking;

class PartnerBookingInfoAction extends \CAction
{
  private $booking;
  private $form;

  public function run($bookingId, $backUrl = null)
  {
    $this->booking = \pay\models\RoomPartnerBooking::model()->findByPk($bookingId);
    if ($this->booking == null)
      throw new \CHttpException(404);

    $this->form = new \pay\models\forms\admin\PartnerBookingInfo($this->booking);
    $car = json_decode($this->booking->Car);
    if ($car !== null)
    {
      $this->form->Car = (array)$car;
    }
    $people = json_decode($this->booking->People);
    if ($people !== null)
    {
      $this->form->People = $people;
    }


    $request = \Yii::app()->getRequest();
    $this->form->attributes = $request->getParam(get_class($this->form));
    if ($request->getIsPostRequest() && $this->form->validate())
    {
      $this->processForm();
    }

    $this->getController()->render('partnerbookinginfo', ['booking' => $this->booking, 'form' => $this->form, 'backUrl' => $backUrl]);
  }

  /**
   *
   */
  private function processForm()
  {
    $this->booking->Car = json_encode($this->form->Car);
    $this->booking->People = json_encode($this->form->People);
    $this->booking->save();
    \Yii::app()->getUser()->setFlash('success', \Yii::t('app', 'Информация о брони успешна сохранена!'));
    $this->getController()->refresh();
  }
} 