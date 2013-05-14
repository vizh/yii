<?php
class UserController extends \application\components\controllers\AdminMainController
{
  public function actionIndex($commissionId)
  {
    $commission = \commission\models\Commission::model()->findByPk($commissionId);
    if ($commission == null)
    {
      throw new \CHttpException(404);
    }
    
    $request = \Yii::app()->getRequest();
    $form = new \commission\models\forms\admin\Users();
    if ($request->getIsPostRequest())
    {
      
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
    
    \Yii::app()->clientScript->registerPackage('runetid.backbone');
    $this->render('index', array('form' => $form));
  }
}
