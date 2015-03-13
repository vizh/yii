<?php

use application\helpers\Flash;
use pay\models\forms\admin\PartnerOrder as PartnerOrderForm;
use pay\models\RoomPartnerOrder;
use \pay\models\search\admin\booking\Partners as PartnersSearch;
use pay\models\RoomPartnerBooking;

class BookingController extends \application\components\controllers\AdminMainController
{
    public function actions()
    {
        return [
            'index' => '\pay\controllers\admin\booking\IndexAction',
            'edit' => '\pay\controllers\admin\booking\EditAction',
            'delete' => '\pay\controllers\admin\booking\DeleteAction',
            'partner' => '\pay\controllers\admin\booking\PartnerAction',
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
     * Страница счета партнера
     * @param string $owner
     * @param int  $id
     * @param bool|null $print
     * @throws CHttpException
     */
    public function actionOrder($owner, $id = null, $print = null)
    {
        $request = \Yii::app()->getRequest();

        $order = null;

        /** @var RoomPartnerOrder $order */
        if ($id !== null) {
            $order = RoomPartnerOrder::model()->byDeleted(false)->findByPk($id);
            if ($order === null || $order->Bookings[0]->Owner != $owner) {
                throw new \CHttpException(404);
            }

            if ($print !== null) {
                $this->renderPartial('print', ['order' => $order, 'owner' => $owner]);
                \Yii::app()->end();
            }

        }

        $form = new PartnerOrderForm($owner, $order);
        $form->BookingIdList = ($id !== null ? \CHtml::listData($order->Bookings, 'Id', 'Id') : $request->getParam('bookingIdList', []));

        $criteria = new \CDbCriteria();
        $criteria->addCondition('"Product"."EventId" = :EventId');
        $criteria->params['EventId'] = \Yii::app()->params['AdminBookingEventId'];

        $model = RoomPartnerBooking::model()->byOwner($owner)->byDeleted(false)->orderBy('"t"."Id"')->with(['Product.Attributes']);
        if ($order !== null && $order->Paid) {
            $model->byOrderId($order->Id);
        }
        $bookings = $model->findAll($criteria);


        if (empty($bookings)) {
            throw new \CHttpException(404);
        }

        if ($request->getIsPostRequest() && ($order === null || !$order->Paid)) {
            $form->fillFromPost();
            $result = $form->isUpdateMode() ? $form->updateActiveRecord() : $form->createActiveRecord();
            if ($result !== null) {
                Flash::setSuccess(\Yii::t('app', 'Счет усешно сохранен'));
                $this->redirect(['order', 'owner' => $form->getOwner(), 'id' => $form->getActiveRecord()->Id]);
            }
        }

        $this->render('order', ['form' => $form, 'bookings' => $bookings, 'order' => $order]);
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