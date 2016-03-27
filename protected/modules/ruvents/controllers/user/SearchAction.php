<?php
namespace ruvents\controllers\user;

use ruvents\components\Exception;
use user\models\User;

class SearchAction extends \ruvents\components\Action
{
    public function run()
    {
        $request = \Yii::app()->getRequest();
        $query = $request->getParam('Query', null);
        $limit = $request->getParam('Limit', 200);
        $locale = $request->getParam('Locale', \Yii::app()->language);
        
        if (empty($query))
            throw new Exception(501);

        $users = [];
        if (filter_var($query, FILTER_VALIDATE_EMAIL)) {
            $user = User::model()
                ->byEmail($query)
                ->byVisible(true)
                ->find();
            
            if ($user !== null)
                $users[] = $user;
        } else {
            $userModel = User::model()->bySearch($query, $locale);
            $criteria = new \CDbCriteria();
            $criteria->with = [
                'LinkPhones.Phone',
                'Employments',
                'Participants'
            ];
            $criteria->limit = $limit;
            $users = $userModel->findAll($criteria);
        }

        $result = ['Users' => []];
        foreach ($users as $user) {
            $this->getDataBuilder()->createUser($user);
            $this->getDataBuilder()->buildUserPhone($user);
            $this->getDataBuilder()->buildUserEmployment($user);
            $result['Users'][] = $this->getDataBuilder()->buildUserEvent($user);
        }

        echo json_encode($result);
    }
}
