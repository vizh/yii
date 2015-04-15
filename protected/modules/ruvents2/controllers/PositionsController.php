<?php
namespace ruvents2\controllers;

use application\components\helpers\ArrayHelper;
use pay\models\OrderItem;
use pay\models\OrderType;
use pay\models\Product;
use ruvents2\components\Controller;
use pay\components\admin\Rif;

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

        // TODO: костыль для РИФ15
        if ($this->getEvent()->IdName == 'rif15') {
            $result = $this->modifyPositionsForRif15($result);
        }

        $nextSince = count($positions) == $limit ? $positions[$limit-1]->CreationTime : null;
        $hasMore = $nextSince !== null;
        $this->renderJson([
            'Positions' => $result,
            'HasMore' => $hasMore,
            'NextSince' => $nextSince
        ]);
    }


    /**
     * @param $positions
     * @return array
     */
    private function modifyPositionsForRif15($positions)
    {
        $foodMap = [
            Rif::HOTEL_LD => [
                3634 => 3771,
                3637 => 3772,
                3640 => 3773
            ],
            Rif::HOTEL_N => [
                3634 => 3774,
                3637 => 3775,
                3640 => 3776
            ],
            Rif::HOTEL_P => [
                3634 => 3768,
                3637 => 3769,
                3640 => 3770
            ]
        ];

        $result = [];
        foreach ($positions as $key => $position) {
            if (in_array($position['ProductId'], [3634,3637,3640])) {
                $hotel = Rif::getUserHotel($position['UserId']);
                if ($hotel === null) {
                    $hotel = Rif::HOTEL_P;
                }
                $position['ProductId'] = $foodMap[$hotel][$position['ProductId']];
            }
            $result[$key] = $position;
        }
        return $result;
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

        $data['UserId'] = $position->ChangedOwner == null ? $position->Owner->RunetId : $position->ChangedOwner->RunetId;

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