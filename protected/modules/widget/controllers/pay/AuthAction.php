<?php
namespace widget\controllers\pay;

class AuthAction extends \widget\components\pay\Action
{
  private $tmpUserForm;

  public function run()
  {
    $request = \Yii::app()->getRequest();
    if ($request->getParam('token') !== null)
    {
      $this->processOAuth();
    }
    $this->tmpUserForm = new \user\models\forms\Email();
    $this->tmpUserForm->attributes = $request->getParam(get_class($this->tmpUserForm));
    if ($request->getIsPostRequest() && $this->tmpUserForm->validate())
    {
      $this->processTmpUserForm();
    }

    if (!\Yii::app()->getUser()->getIsGuest())
    {
      $this->getController()->gotoNextStep();
    }

    \Yii::app()->getClientScript()->registerMetaTag($this->getApiAccount()->Key,'ApiKey');
    $this->getController()->render('auth', ['tmpUserForm' => $this->tmpUserForm]);
  }

  private function processOAuth()
  {
    $request = \Yii::app()->getRequest();
    $token = $request->getParam('token');
    $oauthToken = \oauth\models\AccessToken::model()->byToken($token)->find();
    if ($oauthToken !== null)
    {
      $identity = new \application\components\auth\identity\RunetId($oauthToken->User->RunetId);
      $identity->authenticate();
      if ($identity->errorCode == \application\components\auth\identity\Base::ERROR_NONE)
      {
        \Yii::app()->getUser()->login($identity);
        echo '
        <script type="text/javascript">
          window.opener.location.reload();
          window.close();
        </script>
        ';
        exit();
      }
    }
    throw new \CHttpException(404);
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