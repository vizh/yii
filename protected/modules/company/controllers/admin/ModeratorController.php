<?php
class ModeratorController extends \application\components\controllers\AdminMainController
{
  public function actionIndex($companyId = null)
  {
    $company = null;
    if ($companyId !== null)
    {
      $company = \company\models\Company::model()->findByPk($companyId);
      if ($company == null)
        throw new \CHttpException(404);
    }
    
    $action = \Yii::app()->getRequest()->getParam('Action');
    if ($action !== null && $company !== null)
    {
      $user = \user\models\User::model()->byRunetId(\Yii::app()->getRequest()->getParam('RunetId'))->find();
      switch ($action)
      {
        case 'CreateModerator':
          $linkModerator = new \company\models\LinkModerator();
          $linkModerator->CompanyId = $company->Id;
          $linkModerator->UserId = $user->Id;
          $linkModerator->save();
          break;
        
        case 'RemoveModerator':
          $linkModerator = \company\models\LinkModerator::model()
            ->byUserId($user->Id)->byCompanyId($company->Id)->find();
          if ($linkModerator !== null)
          {
            $linkModerator->delete();
          }
          break;
      }
      
      $this->redirect(
        $this->createUrl('/company/admin/moderator/index', array('companyId' => $company->Id))
      );
    }
    
    $this->render('index', array('company' => $company));
  }
}
