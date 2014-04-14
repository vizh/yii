<?php
class PayController extends \application\components\controllers\PublicMainController
{
  public function actions()
  {
    return [
      'index' => '\widget\controllers\pay\IndexAction',
      'auth' => '\widget\controllers\pay\AuthAction',
      'register' => '\widget\controllers\pay\RegisterAction',
      'cabinet' => '\widget\controllers\pay\CabinetAction',
    ];
  }

  protected function getStepActionMap()
  {
    return [
      'index',
      'auth',
      'register',
      'cabinet'
    ];
  }

  /**
   * @return string
   * @throws CHttpException
   */
  public function getNextStepUrl()
  {
    $step = array_search($this->getAction()->getId(), $this->getStepActionMap());
    if ($step === false || sizeof($this->getStepActionMap()) == ($step+1))
      throw new \CHttpException(404);

    $action = $this->getStepActionMap()[$step+1];
    return $this->createUrl('/widget/pay/'.$action);
  }

  /*
   *
   */
  public function gotoNextStep()
  {
    $this->redirect($this->getNextStepUrl());
  }

  /**
   * @return \user\models\User
   */
  public function getUser()
  {
    if (\Yii::app()->user->getCurrentUser() !== null)
    {
      return \Yii::app()->user->getCurrentUser();
    }
    elseif (\Yii::app()->payUser->getCurrentUser() !== null)
    {
      return \Yii::app()->payUser->getCurrentUser();
    }
    return null;
  }

  protected $account = null;

  /**
   * @return \pay\models\Account
   * @throws Exception
   */
  public function getAccount()
  {
    $this->account = \pay\models\Account::model()->byEventId($this->getEvent()->Id)->find();
    if ($this->account === null)
    {
      throw new \pay\components\Exception('Для работы платежного кабинета необходимо создать платежный аккаунт мероприятия.');
    }
    return $this->account;
  }

  /**
   * @return \event\models\Event
   */
  public function getEvent()
  {
    return \event\models\Event::model()->findByPk(789);
  }
} 