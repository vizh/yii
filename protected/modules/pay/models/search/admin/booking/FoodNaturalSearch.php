<?php

namespace pay\models\search\admin\booking;

class FoodNaturalSearch extends \CFormModel
{
    public static $productIds = [
        '2017-04-18' => [
            'dinner' => '7246',
        ],
        '2017-04-19' => [
            'breakfast' => '7247',
            'lunch' => '7248',
            'dinner' => '7249',
        ],
        '2017-04-20' => [
            'breakfast' => '7250',
            'lunch' => '7251',
            'dinner' => '7252',
        ],
        '2017-04-21' => [
            'breakfast' => '7253',
            'lunch' => '7254',
            'dinner' => '7255',
        ],
    ];

    public function search()
    {
        $query = \Yii::app()->getDb()->createCommand();
        $select = [
            'User.Id as user_id',
            'concat("User"."LastName", \' \', "User"."FirstName", \' \', "User"."FatherName") as user_name',
            'User.RunetId as user_runet_id'
        ];
        foreach (self::$productIds as $date => $meals) {
            foreach ($meals as $meal => $id) {
                $alias = 'poi'.$id;
                $select[] = $alias.'.Id as '.$alias;
                $select[] = $alias.'.Paid as '.$alias.'paid';
                $query->leftJoin('PayOrderItem as '.$alias, $alias.'."OwnerId" = "User"."Id" and '.$alias.'."ProductId" = '.$id.' and not '.$alias.'."Deleted"');
                $query->orWhere($alias.'."Id" is not null');
            }
        }
        $query->select($select)->from('User');
        $query->distinct = true;

        return $query->queryAll();
    }
}