<?php

use application\helpers\Flash;
use pay\models\forms\admin\PartnerOrder as PartnerOrderForm;
use pay\models\RoomPartnerOrder;
use \pay\models\search\admin\booking\Partners as PartnersSearch;
use pay\models\RoomPartnerBooking;
use pay\models\forms\admin\PartnerFoodOrder as PartnerFoodOrderForm;
use pay\models\FoodPartnerOrder;

class BookingController extends \application\components\controllers\AdminMainController
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'index' => 'pay\controllers\admin\booking\IndexAction',
            'edit' => 'pay\controllers\admin\booking\EditAction',
            'delete' => 'pay\controllers\admin\booking\DeleteAction',
            'partner' => 'pay\controllers\admin\booking\PartnerAction',
            'statistics' => 'pay\controllers\admin\booking\StatisticsAction',
            'partnerbookinginfo' => 'pay\controllers\admin\booking\PartnerBookingInfoAction',
            'product' => 'pay\controllers\admin\booking\ProductAction',
            'statisticsHotel' => 'pay\controllers\admin\booking\StatisticsHotelAction',
            'food' => 'pay\controllers\admin\booking\FoodAction',
            'parking' => 'pay\controllers\admin\booking\ParkingAction',
            'list' => 'pay\controllers\admin\booking\ListAction'
        ];
    }

    /**
     * Страница счета партнера
     *
     * @param string $owner
     * @param int $id
     * @param bool|null $print
     * @throws CHttpException
     */
    public function actionOrder($owner, $id = null, $print = null)
    {
        $request = \Yii::app()->getRequest();

        $order = null;

        if ($id) {
            /** @var RoomPartnerOrder $order */
            $order = RoomPartnerOrder::model()->byDeleted(false)->findByPk($id);
            if ($order === null || $order->Bookings[0]->Owner != $owner) {
                throw new \CHttpException(404);
            }

            if ($print !== null) {
                $this->renderPartial('print', ['order' => $order, 'owner' => $owner, 'clear' => false]);
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

        $this->render('order', [
            'form' => $form,
            'bookings' => $bookings,
            'order' => $order
        ]);
    }

    /**
     * Список партнеров
     */
    public function actionPartners()
    {
        $search = new PartnersSearch();
        $this->render('partners', ['search' => $search]);
    }


    /**
     * Выставление счета на питание
     * @param string|null $owner
     * @param int|null $id
     * @param int|null $print
     * @throws CException
     * @throws CHttpException
     */
    public function actionOrderFood($owner = null, $id = null, $print = null)
    {
        $request = \Yii::app()->getRequest();

        $order = null;

        if ($id !== null) {
            $order = FoodPartnerOrder::model()->byDeleted(false)->findByPk($id);
            if ($order === null || $order->Owner !== $owner) {
                throw new \CHttpException(404);
            }

            if ($print !== null) {
                $this->renderPartial('print-food', ['order' => $order, 'owner' => $owner, 'clear' => false]);
                \Yii::app()->end();
            }
        }

        $form = new PartnerFoodOrderForm($owner, $order);
        if ($request->getIsPostRequest()) {
            $form->fillFromPost();
            $result = $form->isUpdateMode() ? $form->updateActiveRecord() : $form->createActiveRecord();
            if ($result !== null) {
                Flash::setSuccess(\Yii::t('app', 'Счет усешно сохранен'));
                $this->redirect(['orderfood', 'owner' => $form->getActiveRecord()->Owner, 'id' => $form->getActiveRecord()->Id]);
            }
        }

        $this->render('order-food', ['form' => $form, 'order' => $order]);
    }

    public function actionPrint($print = null, $clear = false)
    {
        $eventId = \Yii::app()->params['AdminBookingEventId'];
        if (!empty($print)) {
            $result = '';
            $orders = RoomPartnerOrder::model()->byEventId($eventId)->byDeleted(false)->byPaid(true)->orderBy('"t"."CreationTime"')->with('Bookings')->findAll();
            foreach ($orders as $order) {
                $owner = $order->Bookings[0]->Owner;
                $result .= $this->renderPartial('print', ['order' => $order, 'owner' => $owner, 'clear' => (bool)$clear], true);
            }

            $orders = FoodPartnerOrder::model()->byEventId($eventId)->byDeleted(false)->byPaid(true)->orderBy('"t"."CreationTime"')->findAll();
            foreach ($orders as $order) {
                $result .= $this->renderPartial('print-food', ['order' => $order, 'owner' => $order->Owner, 'clear' => (bool)$clear], true);
            }
            echo $result;
            \Yii::app()->end();
        }

        $this->render('print-all');
    }
} 