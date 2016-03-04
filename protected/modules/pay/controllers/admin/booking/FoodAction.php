<?php
namespace pay\controllers\admin\booking;

use pay\components\admin\Rif;

class FoodAction extends \CAction
{
    public function run()
    {
        $dates = ['2016-04-13', '2016-04-14', '2016-04-15'];
        $food = [
            'breakfast' => [4416, 4419, 4422],
            'lunch'     => [4417, 4420, 4423],
            'dinner'    => [4418, 4421, 4424],
            //'boblight'  => [3651, 3653, 3655],
            //'bobhard'   => [3650, 3652, 3654]
        ];

        $users = Rif::getUsersByHotel();

        $usersFood = [];
        $usersFood['breakfastP']  = $this->getFoodUsers($food['breakfast'], array_merge($users['ЛЕСНЫЕ ДАЛИ'], $users['НАЗАРЬЕВО']), true);
        $usersFood['breakfastLD'] = $this->getFoodUsers($food['breakfast'], $users['ЛЕСНЫЕ ДАЛИ']);
        $usersFood['breakfastN']  = $this->getFoodUsers($food['breakfast'], $users['НАЗАРЬЕВО']);
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
