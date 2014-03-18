<?php
namespace pay\controllers\admin\booking;

class PartnersAction extends \CAction
{
  public function run()
  {
    $results = [];
    $bookings = \pay\models\RoomPartnerBooking::model()->byDeleted(false)->findAll(['order' => '"t"."Owner" ASC']);
    foreach ($bookings as $booking)
    {
      $key = $booking->Owner;
      if (!isset($results[$key]))
      {
        $results[$key] = new \stdClass();
        $results[$key]->Partner = $booking->Owner;
        $results[$key]->Paid = 0;
        $results[$key]->Ordered = 0;
      }

      $results[$key]->Ordered++;
      if ($booking->Paid)
      {
        $results[$key]->Paid++;
      }
    }

    $this->getController()->setPageTitle(\Yii::t('app', 'Номерной фонд партнеров'));
    $this->getController()->render('partners', ['results' => $results]);
  }
} 