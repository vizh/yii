<?php
namespace ruvents2\controllers;

use application\components\helpers\ArrayHelper;
use pay\models\OrderItem;
use pay\models\OrderType;
use ruvents2\components\Controller;

class PositionsController extends Controller
{
    const MAX_LIMIT = 500;

    public function actionList($since = null, $limit = null)
    {
        $limit = intval($limit);
        $limit = $limit > 0 ? min($limit, self::MAX_LIMIT) : self::MAX_LIMIT;
        $criteria = $this->getCriteria($since, $limit);
        $positions = OrderItem::model()->byEventId($this->getEvent()->Id)->findAll($criteria);
        $result = [];
        foreach ($positions as $position) {
            $result[] = $this->getPositionData($position);
        }

        $nextSince = count($positions) == $limit ? $positions[$limit-1]->CreationTime : null;
        $hasMore = $nextSince !== null;
        $this->renderJson([
            'Badges' => $result,
            'HasMore' => $hasMore,
            'NextSince' => $nextSince
        ]);
    }

    /**
     * @param string $since
     * @param int $limit
     * @return \CDbCriteria
     */
    private function getCriteria($since, $limit)
    {
        $criteria = new \CDbCriteria();
        $criteria->with = ['Owner', 'ChangedOwner', 'OrderLinks.Order'];
        $criteria->order = 't."UpdateTime"';
        $criteria->limit = $limit;

        if ($since !== null) {
            $since = date('Y-m-d H:i:s', strtotime($since));
            $criteria->addCondition('t."CreationTime" >= :CreationTime');
            $criteria->params = ['CreationTime' => $since];
        }
        return $criteria;
    }

    /**
     * @param OrderItem $position
     * @return array
     */
    private function getPositionData($position)
    {
        $data = ArrayHelper::toArray($position, ['pay\models\OrderItem' => [
            'Id', 'ProductId', 'Paid', 'PaidTime', 'UpdateTime'
        ]]);

        $couponActivation = $position->getCouponActivation();

        if ($couponActivation !== null) {
            $data['Discount'] = (int)($couponActivation->Coupon->Discount * 100);
            $data['PromoCode'] = $couponActivation->Coupon->Code;
        } else {
            $data['Discount'] = 0;
            $data['PromoCode'] = null;
        }

        if ($data['Discount'] == 100) {
            $data['PayType'] = 'promo';
        } else {
            $data['PayType'] = 'individual';
            foreach ($position->OrderLinks as $link) {
                if ($link->Order->Type == OrderType::Juridical && $link->Order->Paid) {
                    $data['PayType'] = 'juridical';
                    break;
                }
            }
        }

        return $data;
    }
}