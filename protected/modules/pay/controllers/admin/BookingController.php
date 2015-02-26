<?php

use \pay\models\search\admin\booking\Partners as PartnersSearch;

class BookingController extends \application\components\controllers\AdminMainController
{
  public function actions()
  {
    return [
      'index' => '\pay\controllers\admin\booking\IndexAction',
      'edit' => '\pay\controllers\admin\booking\EditAction',
      'delete' => '\pay\controllers\admin\booking\DeleteAction',
      'partner' => '\pay\controllers\admin\booking\PartnerAction',
      'order' => '\pay\controllers\admin\booking\OrderAction',
      'statistics' => '\pay\controllers\admin\booking\StatisticsAction',
      'partnerbookinginfo' => '\pay\controllers\admin\booking\PartnerBookingInfoAction',
      'product' => '\pay\controllers\admin\booking\ProductAction',
      'statisticsHotel' => '\pay\controllers\admin\booking\StatisticsHotelAction',
      'food' => '\pay\controllers\admin\booking\FoodAction',
      'parking' => '\pay\controllers\admin\booking\ParkingAction',
      'list' => '\pay\controllers\admin\booking\ListAction'
    ];
  }

    /**
     * Список партнеров
     */
    public function actionPartners()
    {
        $search = new PartnersSearch();
        $this->render('partners', ['search' => $search]);
    }
} 