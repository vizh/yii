<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 14.04.2015
 * Time: 12:45
 */

namespace ruvents2\controllers;

use application\components\helpers\ArrayHelper;
use pay\models\Product;
use pay\models\ProductCheck;
use ruvents2\components\Controller;
use ruvents2\components\data\CDbCriteria;
use ruvents2\components\Exception;
use user\models\User;

class ProductsController extends Controller
{
    const MAX_LIMIT = 200;

    /**
     * Список отметок о выдаче товаров
     * @param int $id
     * @param int $since
     * @param int $limit
     * @throws \application\components\Exception
     */
    public function actionChecks($id, $since = null, $limit = null)
    {
        $limit = intval($limit);
        $limit = $limit > 0 ? min($limit, self::MAX_LIMIT) : self::MAX_LIMIT;
        $criteria = $this->getCheckCriteria($since, $limit);
        $result = [];

        $checks = ProductCheck::model()->byEventId($this->getEvent()->Id)->byProductId($id)->findAll($criteria);
        foreach ($checks as $check) {
            $result[] = $this->getCheckData($check);
        }

        $nextSince = count($checks) == $limit ? $checks[$limit - 1]->CreationTime : null;
        $hasMore = $nextSince !== null;
        $this->renderJson([
            'Checks' => $result,
            'HasMore' => $hasMore,
            'NextSince' => $nextSince
        ]);
    }

    /**
     * Выдача товара
     * @param int $id
     * @throws Exception
     * @throws \application\components\Exception
     */
    public function actionCheck($id)
    {
        $request = \Yii::app()->getRequest();
        $runetId = $request->getParam('UserId');
        $user = User::model()->byRunetId($runetId)->find();
        if ($user === null) {
            throw new Exception(Exception::INVALID_PARTICIPANT_ID, $runetId);
        }

        $time = $request->getParam('CheckTime');
        if ($time === null) {
            throw new Exception(Exception::INVALID_PARAM, ['CheckTime', $time]);
        }

        $product = Product::model()->byEventId($this->getEvent()->Id)->findByPk($id);
        if ($product === null) {
            throw new Exception(Exception::INVALID_PRODUCT_ID, $id);
        }

        $check = new ProductCheck();
        $check->OperatorId = $this->getOperator()->Id;
        $check->UserId = $user->Id;
        $check->CheckTime = $time;
        $check->ProductId = $product->Id;
        $check->save();
        $this->renderJson(['Id' => $check->Id]);
    }

    /**
     * @param string $since
     * @param int $limit
     * @return CDbCriteria
     */
    private function getCheckCriteria($since, $limit)
    {
        $criteria = CDbCriteria::create()
            ->setOrder('t."CreationTime"')
            ->setLimit($limit);

        if ($since !== null) {
            $since = date('Y-m-d H:i:s', strtotime($since));
            $criteria->addConditionWithParams('t."CreationTime" >= :CreationTime', ['CreationTime' => $since]);
        }

        return $criteria;
    }

    /**
     * @param ProductCheck $check
     * @return array
     */
    private function getCheckData(ProductCheck $check)
    {
        $data = ArrayHelper::toArray($check, [
            'pay\models\ProductCheck' => [
                'Id',
                'CheckTime',
                'CreationTime'
            ]
        ]);
        $data['UserId'] = $check->User->RunetId;
        return $data;
    }
}