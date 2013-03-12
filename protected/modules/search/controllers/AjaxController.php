<?php
class AjaxController extends \application\components\controllers\PublicMainController
{
  public function actionIndex($term)
  {
    $search = new \search\models\Search();
    
    $criteria = new \CDbCriteria();
    $criteria->with = array(
      'Employments' => array('together' => false),
      'Settings'
    );
    $criteria->limit = 5;
    $userModel = \user\models\User::model();
    $userModel->getDbCriteria()->mergeWith($criteria);
    $search->appendModel($userModel);
    
   
    $criteria = new \CDbCriteria();
    $criteria->with = array(
      'LinkAddress.Address.City',
      'Employments' => array('together' => false),
      'LinkPhones' => array(
        'together' => false,
        'with' => array('Phone')
      ),
      'LinkEmails' => array(
        'together' => false,
        'with' => array('Email')
      ),
      'LinkSite.Site'
    );
    $criteria->limit = 5;
    $companyModel = \company\models\Company::model();
    $companyModel->getDbCriteria()->mergeWith($criteria);
    $search->appendModel($companyModel);
    
    $response = array();

    $results = $search->findAll($term);
    if (!empty($results->Results))
    {
      foreach ($results->Results as $model => $records)
      {
        foreach ($records as $record)
        {
          $item = new \stdClass();
          switch ($model)
          {
            case get_class($userModel):
              $item->url = $this->createUrl('/user/view/index', array('runetId' => $record->RunetId));
              $item->value = $record->getFullName();
              $item->runetid = $record->RunetId;
              $item->category = \Yii::t('app', 'Пользователи');
              break;
            
            case get_class($companyModel):
              $item->url = $this->createUrl('/company/view/index', array('companyId' => $record->Id));
              $item->value = $record->Name;
              if ($record->LinkAddress !== null) 
              {
                $item->locality = $record->LinkAddress->Address->City->Name;
              }
              $item->category = \Yii::t('app', 'Компании');
              break;
          }
          $response[] = $item;
        }
      }
    }
    echo json_encode($response);
  }
}
