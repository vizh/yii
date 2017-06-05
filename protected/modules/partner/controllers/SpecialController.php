<?php

class SpecialController extends \partner\components\Controller
{
    public function actions()
    {
        if (Yii::app()->partner->getIsGuest()) {
            $this->redirect(Yii::app()->createUrl('/partner/auth/index'));
        }
        if (Yii::app()->partner->getEvent()->IdName == 'rif13') {
            return [
                'rooms' => 'partner\controllers\special\rif13\RoomsAction',
                'book' => 'partner\controllers\special\rif13\BookAction',
                'food' => 'partner\controllers\special\rif13\FoodAction',
                'clearbook' => 'partner\controllers\special\rif13\ClearbookAction',
                'bookinfo' => 'partner\controllers\special\rif13\BookinfoAction',
                'bookchanges' => 'partner\controllers\special\rif13\BookchangesAction',
                'fixchanges' => 'partner\controllers\special\rif13\FixchangesAction',
            ];
        } elseif (Yii::app()->partner->getEvent()->IdName == 'mademoscow15') {
            return [
                'export' => 'partner\controllers\special\mademoscow15\ExportAction'
            ];
        } else {
            return ['exportnopaid' => '\partner\controllers\special\ExportnopaidAction'];
        }
    }
}
