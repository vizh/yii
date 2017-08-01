<?php

use pay\components\Controller;
use pay\models\Account;

class CabinetController extends Controller
{
    /**
     * @return array Фильтры
     */
    public function filters()
    {
        return array_merge(parent::filters(), [
            'postOnly + deleteitem'
        ]);
    }

    public function actions()
    {
        return [
            'register' => 'pay\controllers\cabinet\RegisterAction',
            'index' => 'pay\controllers\cabinet\IndexAction',
            'deleteitem' => 'pay\controllers\cabinet\DeleteItemAction',
            'pay' => 'pay\controllers\cabinet\PayAction',
            'offer' => 'pay\controllers\cabinet\OfferAction',
            'auth' => 'pay\controllers\cabinet\AuthAction'
        ];
    }

    /**
     * @inheritdoc
     */
    protected function setHeaders()
    {
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Origin: http://pay.'.RUNETID_HOST);
        parent::setHeaders();
    }

    /**
     * Редирект после оплаты
     *
     * @param $eventIdName
     * @param $orderId
     * @throws CHttpException
     */
    public function actionReturn($eventIdName, $orderId = null)
    {
        $account = Account::model()
            ->byEventId($this->getEvent()->Id)
            ->find();

        if ($account !== null) {
            if ($account->AfterPayUrl !== null) {
                $this->redirect($account->AfterPayUrl);
            }

            if ($account->ReturnUrl !== null) {
                $this->redirect($account->ReturnUrl);
            }
        }

        $this->redirect(['/event/view/index', 'idName' => $eventIdName, 'orderId' => $orderId]);
    }

}
