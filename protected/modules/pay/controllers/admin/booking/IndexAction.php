<?php
namespace pay\controllers\admin\booking;

class IndexAction extends \CAction
{
  public function run()
  {
    $request = \Yii::app()->request;
    $form = new \pay\models\forms\admin\BookingSearch();
    if ($request->isPostRequest)
      $form->attributes = $request->getParam(get_class($form));

    $this->getController()->render('index', [
      'form' => $form,
      'rooms' => $form->searchRooms()
    ]);
  }
} 