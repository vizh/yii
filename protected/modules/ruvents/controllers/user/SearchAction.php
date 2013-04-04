<?php
namespace ruvents\controllers\user;

class SearchAction extends \ruvents\components\Action
{
  public function run()
  {
    $request = \Yii::app()->getRequest();
    $query = $request->getParam('Query', null);
    $locale = $request->getParam('Locale', \Yii::app()->language);
    if (empty($query))
    {
      throw new \ruvents\components\Exception(501);
    }

    $users = array();
    if (filter_var($query, FILTER_VALIDATE_EMAIL))
    {
      $user = \user\models\User::model()->byEmail($query)->find();
      if ($user !== null)
      {
        $users[] = $user;
      }
    }
    else
    {
      $userModel = \user\models\User::model()->bySearch($query, $locale);
      $criteria = new \CDbCriteria();
      $criteria->with = array(
        'LinkPhones.Phone',
        'Employments',
        'Participants'
      );
      $criteria->limit = 200;
      $users = $userModel->findAll($criteria);
    }

    $result = array('Users' => array());
    foreach ($users as $user)
    {
      $this->getDataBuilder()->createUser($user);
      $this->getDataBuilder()->buildUserPhone($user);
      $this->getDataBuilder()->buildUserEmployment($user);
      $result['Users'][] = $this->getDataBuilder()->buildUserEvent($user);
    }

    echo json_encode($result);
  }
}
