<?php
namespace pay\controllers\admin\booking;

use pay\components\admin\Rif;

class FoodAction extends \CAction
{
    public function run()
    {
        $dates = ['2017-04-19', '2017-04-20', '2017-04-21'];
        $food = [
            'breakfast' => [7247, 7250, 7253],
            'lunch'     => [7248, 7251, 7254],
            'dinner'    => [7249, 7252, 7255],
        ];

        $users = Rif::getUsersByHotel();

        $usersFood = [];
        $usersFood['breakfastP']  = $this->getFoodUsers($food['breakfast'], array_merge(isset($users['ЛЕСНЫЕ ДАЛИ']) ? $users['ЛЕСНЫЕ ДАЛИ'] : [], isset($users['НАЗАРЬЕВО']) ? $users['НАЗАРЬЕВО'] : []), true);
        $usersFood['breakfastLD'] = $this->getFoodUsers($food['breakfast'], isset($users['ЛЕСНЫЕ ДАЛИ']) ? $users['ЛЕСНЫЕ ДАЛИ'] : []);
        $usersFood['breakfastN']  = $this->getFoodUsers($food['breakfast'], isset($users['НАЗАРЬЕВО']) ? $users['НАЗАРЬЕВО'] : []);
        $usersFood['lunchP']      = $this->getFoodUsers($food['lunch'], [], true);
        $usersFood['lunchLD']     = [];
        $usersFood['dinnerP']     = $this->getFoodUsers($food['dinner'], [], true);;
        $usersFood['dinnerLD']    = [];

        $this->getController()->render('food', [
            'dates' => $dates,
            'food' => $food,
            'usersFood' => $usersFood
        ]);
    }

    private function getFoodUsers($products, $users, $useNot = false)
    {
        $criteria = new \CDbCriteria();
        $criteria->with = [
            'Owner' => ['together' => true],
            'ChangedOwner' => ['together' => true]
        ];
        if (!$useNot) {
            $criteria->addCondition('t."ChangedOwnerId" IS NULL');
            $criteria->addInCondition('"Owner"."RunetId"', $users);
            $criteria->addInCondition('"ChangedOwner"."RunetId"', $users, 'OR');
        }
        else
        {
            $criteria->addNotInCondition('"Owner"."RunetId"', $users);
        }
        $criteria->addInCondition('t."ProductId"', $products);
        $foodItems = \pay\models\OrderItem::model()->byPaid(true)->findAll($criteria);
        $result = [];
        foreach ($foodItems as $item)
        {
            $owner = $item->ChangedOwnerId != null ? $item->ChangedOwner : $item->Owner;
            $result[$item->ProductId][] = $owner->RunetId;
        }
        return $result;
    }
}
