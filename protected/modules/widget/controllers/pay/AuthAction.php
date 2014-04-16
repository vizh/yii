<?php
namespace widget\controllers\pay;

class AuthAction extends \widget\components\pay\Action
{
  private $tmpUserForm;

  public function run()
  {
    if (!\Yii::app()->getUser()->getIsGuest())
    {
      $this->getController()->gotoNextStep();
    }

    $request = \Yii::app()->getRequest();
    $this->tmpUserForm = new \user\models\forms\Email();
    $this->tmpUserForm->attributes = $request->getParam(get_class($this->tmpUserForm));
    if ($request->getIsPostRequest() && $this->tmpUserForm->validate())
    {
      $this->processTmpUserForm();
    }
    $this->getController()->render('auth', ['tmpUserForm' => $this->tmpUserForm]);
  }

  /**
   * @throws \CHttpException
   */
  private function processTmpUserForm()
  {
    $user = new \user\models\User();
    $user->LastName = $user->FirstName = '';
    $user->Email = $this->tmpUserForm->Email;
    $user->Visible = false;
    $user->Temporary = true;
    $user->register();
    $identity = new \application\components\auth\identity\RunetId($user->RunetId);
    $identity->authenticate();
    if ($identity->errorCode == \application\components\auth\identity\Base::ERROR_NONE)
    {
      \Yii::app()->payUser->login($identity);
      $this->getController()->refresh();
    }
    else
    {
      throw new \CHttpException(404);
    }
  }
} 