<?php

namespace pay\components\coupon\collection\managers;

use pay\components\OrderItemCollection;
use user\models\User;

/**
 * Class OneCompanyCount
 * @package pay\components\coupon\collection\managers
 */
class OneCompanyCount extends Count
{
    /**
     * Возвращает количество id компаний
     * в которых работают пользователи, указанные в счете
     * @param OrderItemCollection $collection
     * @return mixed
     */
    protected function checkOneCompany(OrderItemCollection $collection)
    {
        $ids = $this->getUniqueOwnerIdList($collection);

        if (is_array($ids) || !empty($ids)) {
            $users = [];
            foreach ($ids as $id) {
                $users[] = User::model()->with("Employments")->findByPk($id);
            }

            $companyIds = [];
            foreach ($users as $user) {
                if (!empty($user->Employments)) {

                    foreach ($user->Employments as $employment) {
                        if ($employment->Primary) {
                            $companyIds[$employment->UserId] = $employment->CompanyId;
                        }
                    }
                }
            }
            
            return array_count_values($companyIds);
        }
    }

    /**
     * @inheritdoc
     */
    public function getDiscount(OrderItemCollection $collection)
    {
        $countIds = $this->checkOneCompany($collection);
        
        foreach ($countIds as $key => $value) {
            if ($value >= $this->Minimum) {
                return $this->getMinPrice($collection) / 100 * $this->coupon->Discount;
            }
        }

        return 0;
    }
}
