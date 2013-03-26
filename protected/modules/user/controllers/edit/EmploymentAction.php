<?php
namespace user\controllers\edit;
class EmploymentAction extends \CAction
{
  public function run()
  {
    $user = \Yii::app()->user->getCurrentUser();
    $request = \Yii::app()->getRequest();
    $form = new \user\models\forms\edit\Employments();
    $form->attributes = $request->getParam(get_class($form));
    if ($request->getIsPostRequest() && $form->validate())
    {
      foreach ($form->Employments as $item)
      {
        if (!empty($item['Id']))
        {
          $employment = \user\models\Employment::model()->byUserId($user->Id)->findByPk($item['Id']);
        }
        else
        {
          $employment = $user->setEmployment($item['Company'], $item['Position']);
        }
        
        if ($employment !== null)
        {
          if ($item['Deleted'] == 1) 
          {
            $employment->delete();
            continue;
          }
          if (!empty($item['Company']) 
            && $employment->Company->Name !== $item['Company'])
          {
            $employment->delete();
            $employment = $user->setEmployment($item['Company']);
          }
          $employment->Position = $item['Position'];
          $employment->StartMonth = $item['StartMonth'];
          $employment->StartYear = $item['StartYear'];
          $employment->EndMonth = isset($item['EndMonth']) ? $item['EndMonth'] : null;
          $employment->EndYear = isset($item['EndYear']) ? $item['EndYear'] : null;
          $employment->Primary = (isset($item['Primary']) && $item['Primary'] == 1) ? true : false;
          $employment->save();
        }
      }
      \Yii::app()->user->setFlash('success', \Yii::t('app', 'Карьера успешно сохранена!'));
      $this->getController()->refresh();
    }
    
    $this->getController()->bodyId = 'user-account';
    $this->getController()->setPageTitle(\Yii::t('app','Редактирование профиля'));
    $this->getController()->render('employment', array('user' => $user, 'form' => $form));
  }
}
