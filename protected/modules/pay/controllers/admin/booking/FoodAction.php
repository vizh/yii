<?php
namespace pay\controllers\admin\booking;

use pay\components\admin\Rif;

class FoodAction extends \CAction
{
    public function run()
    {
        $dates = ['2014-04-22', '2014-04-23', '2014-04-24'];
        $food = [
            'breakfast' => [3634, 3637, 3640],
            'lunch'     => [3635, 3638, 3641],
            'dinner'    => [3636, 3639, 3642],
            'boblight'  => [3651, 3653, 3655],
            'bobhard'   => [3650, 3652, 3654]
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