<?php
namespace ruvents\controllers\user;

class SearchAction extends \ruvents\components\Action
{
  public function run()
  {
    //todo:

    throw new \application\components\Exception('Not implement yet');

    $request = Yii::app()->getRequest();
    $query = $request->getParam('Query', null);
    $locale = $request->getParam('Locale', \Yii::app()->language);
    if (empty($query))
    {
      throw new \ruvents\components\Exception(501);
    }

    $criteriaWith = array(
      'Emails' => array('together' => true),
      'Phones',
      'Employments',
      'Settings' => array('together' => true)
    );

    if (filter_var($query, FILTER_VALIDATE_EMAIL))
    {
      $user = \user\models\User::GetByEmail($query, $criteriaWith);
      if ($user === null)
      {
        $criteria = new CDbCriteria();
        $criteria->condition = 'Emails.Email = :Email';
        $criteria->params[':Email'] = $query;
        $criteria->with = $criteriaWith;
        $users = \user\models\User::model()->findAll($criteria);
      }
      else
      {
        $users[] = $user;
      }
    }
    else
    {
      $userModel = \user\models\User::model()->bySearch($query, $locale);
      $criteria = new CDbCriteria();
      $criteria->with  = $criteriaWith;
      $criteria->limit = 200;
      $users = $userModel->findAll($criteria);
    }

    $result = array('Users' => array());
    if (!empty($users))
    {
      foreach ($users as $user)
      {
        $result['Users'][] = $this->buildUser($user);
      }
    }
    echo json_encode($result);
  }
}
