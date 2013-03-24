<?php
namespace partner\controllers\user;

class AjaxGetAction extends \partner\components\Action
{
  public function run()
  {
    $term = \Yii::app()->request->getParam('term');
    
    if (strpos($term, '@'))
    {
      $crietria = new \CDbCriteria();
      $crietria->with = array('Emails', 'Employments');
      $crietria->condition = 'Emails.Email = :Email OR t.Email = :Email';
      $crietria->params['Email'] = $term;
    }
    else 
    {
      $crietria = \user\models\User::GetSearchCriteria($term);
      $crietria->limit = 10;
      $crietria->with = array('Settings', 'Employments'); 
    }
    $users = \user\models\User::model()->findAll($crietria);
    $result = array();
    if (!empty($users))
    {
      foreach ($users as $user)
      {
        $employment = $user->GetPrimaryEmployment();
        
        $result[] = array(
          'id' => $user->RocId, 
          'label' => $user->GetFullName(true).($employment !== null ? ' ('.$employment->Company->Name.')' : '')
        );
      }
    }
    echo json_encode($result);
  }
}