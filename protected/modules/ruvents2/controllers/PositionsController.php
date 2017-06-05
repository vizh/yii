<?php
namespace ruvents2\controllers;

use application\components\helpers\ArrayHelper;
use pay\models\OrderItem;
use pay\models\OrderType;
use ruvents2\components\Controller;
use ruvents2\components\data\CDbCriteria;

class PositionsController extends Controller
{
    const MAX_LIMIT = 500;

    public function actionList($since = null, $limit = null)
    {
        $limit = intval($limit);
        $limit = $limit > 0 ? min($limit, self::MAX_LIMIT) : self::MAX_LIMIT;
        $criteria = $this->getCriteria($since, $limit);
        $positions = OrderItem::model()->byEventId($this->getEvent()->Id)->byPaid(true)->with(['Owner', 'ChangedOwner'])->findAll($criteria);
        $result = [];
        foreach ($positions as $position) {
            $result[] = $this->getPositionData($position);
        }

        $nextSince = count($positions) == $limit ? $positions[$limit - 1]->CreationTime : null;
        $hasMore = $nextSince !== null;
        $this->renderJson([
            'Positions' => $result,
            'HasMore' => $hasMore,
            'NextSince' => $nextSince
        ]);
    }

    /**
     * @param string $since
     * @param int $limit
     * @return CDbCriteria
     */
    private function getCriteria($since, $limit)
    {
        $criteria = CDbCriteria::create()
            ->setWith(['Owner', 'ChangedOwner', 'OrderLinks.Order', 'Product'])
            ->setOrder('t."UpdateTime"')
            ->setLimit($limit);

        if ($this->getEvent()->IdName == 'devcon15') {
            $criteria->addCondition('"Product"."ManagerName" = \'FoodProductManager\'');
        }

        if ($since !== null) {
            $since = date('Y-m-d H:i:s', strtotime($since));
            $criteria->addConditionWithParams('t."CreationTime" >= :CreationTime', ['CreationTime' => $since]);
        }

        return $criteria;
    }

    /**
     * @param OrderItem $position
     * @return array
     */
    private function getPositionData($position)
    {
        $data = ArrayHelper::toArray($position, [
            'pay\models\OrderItem' => [
                'Id',
                'ProductId',
                'Paid',
                'PaidTime',
                'UpdateTime'
            ]
        ]);

        $data['UserId'] = $position->ChangedOwner == null ? $position->Owner->RunetId : $position->ChangedOwner->RunetId;

        $couponActivation = $position->getCouponActivation();

        if ($couponActivation !== null) {
            $data['Discount'] = $couponActivation->Coupon->getManager()->getDiscountString();
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