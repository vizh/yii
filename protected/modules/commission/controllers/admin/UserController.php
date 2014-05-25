<?php
class UserController extends \application\components\controllers\AdminMainController
{
  public function actionIndex($commissionId)
  {
    $criteria = new \CDbCriteria();
    $criteria->with = array('Users.Role');
    $criteria->order = '"Role"."Priority" DESC, "Users"."ExitTime" DESC';
    $commission = \commission\models\Commission::model()->findByPk($commissionId, $criteria);
    if ($commission == null)
    {
      throw new \CHttpException(404);
    }
    
    $request = \Yii::app()->getRequest();
    $form = new \commission\models\forms\admin\Users();
    $form->attributes = $request->getParam(get_class($form));
    if ($request->getIsPostRequest())
    {
      if ($form->validate())
      {
        foreach ($form->Users as $formUser)
        {
          if (!empty($formUser->Id))
          {
            $commissionUser = \commission\models\User::model()->findByPk($formUser->Id);
            if ($commissionUser == null)
              throw new \CHttpException(500);
          }
          else
          {
            $commissionUser = new \commission\models\User();
          }
          $commissionUser->UserId = user\models\User::model()->byRunetId($formUser->RunetId)->find()->Id;
          $commissionUser->JoinTime = \Yii::app()->dateFormatter->format('yyyy-MM-dd', $formUser->JoinDate);
          $commissionUser->ExitTime = !empty($formUser->ExitDate) ? \Yii::app()->dateFormatter->format('yyyy-MM-dd', $formUser->ExitDate) : null;
          $commissionUser->RoleId = $formUser->RoleId;
          $commissionUser->CommissionId = $commission->Id;
          $commissionUser->save();
        }
        \Yii::app()->user->setFlash('success', \Yii::t('app', 'Информация об участниках секции успешно сохранена!'));
        $this->refresh();
      }
    }
    else
    {
      foreach ($commission->Users as $user)
      {
        $formUser = new \commission\models\forms\User();
        $formUser->Id       = $user->Id;
        $formUser->RunetId  = $user->User->RunetId;
        $formUser->RoleId   = $user->RoleId;
        $formUser->JoinDate = \Yii::app()->dateFormatter->format(\commission\models\forms\User::DATE_FORMAT, $user->JoinTime);
        $formUser->ExitDate = \Yii::app()->dateFormatter->format(\commission\models\forms\User::DATE_FORMAT, $user->ExitTime);
        $form->Users[] = $formUser;
      }
    }
    
    $this->setPageTitle(\Yii::t('app', '{commission} &mdash; члены', array('{commission}' => $commission->Title)));
    \Yii::app()->clientScript->registerPackage('runetid.backbone');
    $this->render('index', array('form' => $form));
  }
}
