<?php

class MainController extends \application\components\controllers\PublicMainController
{
  public $layout = '/layouts/public';

  /** @var \competence\models\Test */
  public $test;

  /** @var \competence\models\Question */
  public $question;

  public function actions()
  {
    return [
      'process' => 'competence\controllers\main\ProcessAction',
    ];
  }

  /**
   * @return \competence\models\Test
   */
  public function getTest()
  {
    if ($this->test == null)
    {
      $this->test = \competence\models\Test::model()->findByPk($this->actionParams['id']);
    }
    return $this->test;
  }

  protected function beforeAction($action)
  {
    $cs = \Yii::app()->clientScript;
    $manager = \Yii::app()->getAssetManager();
    $path = \Yii::getPathOfAlias('competence.assets');
    $cs->registerCssFile($manager->publish($path . '/css/competence.css'));
    \Yii::app()->getClientScript()->registerScriptFile($manager->publish($path . '/js/unchecker.js'), \CClientScript::POS_END);

    if ($this->getTest() == null || !$this->getTest()->Enable)
      throw new \CHttpException(404);

    if ($this->getUserKey() == null && \Yii::app()->user->getCurrentUser() == null)
    {
      $this->render('competence.views.system.unregister');
      return false;
    }

    if (!$this->getTest()->Test && !$this->getTest()->Multiple)
    {
      $model = \competence\models\Result::model()->byTestId($this->getTest()->Id)->byFinished();
      if ($this->userKey !== null)
      {
        $model->byUserKey($this->getUserKey());
      }
      else
      {
        $model->byUserId(\Yii::app()->user->getCurrentUser()->Id);
      }
      $result = $model->find();
      if ($result != null && $action->getId() != 'end' && $action->getId() != 'done')
      {
        $this->redirect(\Yii::app()->createUrl('/competence/main/done', ['id' => $this->getTest()->Id]));
      }
    }

    $this->getTest()->setUser(\Yii::app()->user->getCurrentUser());
    $this->getTest()->setUserKey($this->getUserKey());
    return parent::beforeAction($action);
  }

  private $userKey = null;

  protected function getUserKey()
  {
    if ($this->getTest()->FastAuth)
    {
      if ($this->userKey == null)
      {
        $userKey = $this->getUserKeyValue();
        $userHash = $this->getUserHashValue();
        if ($this->checkUserKeyHash($userKey, $userHash))
        {
          $this->userKey = $userKey;
          $request = Yii::app()->getRequest();
          if (!isset($request->cookies[$this->getUserKeyCookieName()]) || $request->cookies[$this->getUserKeyCookieName()]->value != $userKey)
          {
            $expire = time()+60*60*24*30;
            Yii::app()->request->cookies[$this->getUserKeyCookieName()] = new CHttpCookie($this->getUserKeyCookieName(), $userKey, ['expire' => $expire]);
            Yii::app()->request->cookies[$this->getUserHashCookieName()] = new CHttpCookie($this->getUserHashCookieName(), $userHash, ['expire' => $expire]);
          }
        }
      }
      return $this->userKey;
    }
    return null;
  }

  private function getUserKeyCookieName()
  {
    return 'CompetenceUserKey'.$this->getTest()->Id;
  }

  private function getUserHashCookieName()
  {
    return 'CompetenceUserHash'.$this->getTest()->Id;
  }

  private function getUserKeyValue()
  {
    $request = Yii::app()->getRequest();
    $userKey = $request->getParam('userKey');
    if (empty($userKey))
    {
      $userKey = isset($request->cookies[$this->getUserKeyCookieName()]) ? $request->cookies[$this->getUserKeyCookieName()]->value : substr(md5(microtime()), 0, 10);
    }
    return $userKey;
  }

  private function getUserHashValue()
  {
    $request = Yii::app()->getRequest();
    $userHash = $request->getParam('userHash');
    if (empty($userHash))
    {
      $userHash = isset($request->cookies[$this->getUserHashCookieName()]) ? $request->cookies[$this->getUserHashCookieName()]->value : null;
    }
    return $userHash;
  }

  private function checkUserKeyHash($key, $hash = null)
  {
    if ($this->getTest()->FastAuthSecret !== null)
    {
      return $hash == md5($key.$this->getTest()->FastAuthSecret);
    }
    else
      return true;
  }

  public function actionIndex($id)
  {
    $this->setPageTitle(strip_tags($this->getTest()->Title));
    if (\Yii::app()->request->getIsPostRequest())
    {
      if ($this->getTest()->Test)
      {
        $this->test->getFirstQuestion()->getForm()->clearResult();
        $this->test->getFirstQuestion()->getForm()->clearRotation();
      }
      $this->redirect($this->createUrl('/competence/main/process', ['id' => $id]));
    }
    $this->render('index', ['test' => $this->getTest()]);
  }

  public function actionEnd($id)
  {
    $this->setPageTitle(strip_tags($this->getTest()->Title));

    if ($this->getTest()->Id)

    $this->render($this->getTest()->getEndView(), ['done' => false, 'test' => $this->getTest()]);
  }

  public function actionDone($id)
  {
    $this->setPageTitle(strip_tags($this->getTest()->Title));
    $this->render('end', ['done' => true]);
  }

}