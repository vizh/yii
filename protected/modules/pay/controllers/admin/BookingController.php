<?php

class BookingController extends \application\components\controllers\AdminMainController
{
  const EventId = 789;

  public function actions()
  {
    return [
      'index' => '\pay\controllers\admin\booking\IndexAction',
      'edit' => '\pay\controllers\admin\booking\EditAction',
      'delete' => '\pay\controllers\admin\booking\DeleteAction',
      'partners' => '\pay\controllers\admin\booking\PartnersAction',
      'partner' => '\pay\controllers\admin\booking\PartnerAction',
      'order' => '\pay\controllers\admin\booking\OrderAction',
      'statistics' => '\pay\controllers\admin\booking\StatisticsAction'
    ];
  }
} 