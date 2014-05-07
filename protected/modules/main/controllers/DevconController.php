<?php

class DevconController extends \application\components\controllers\PublicMainController
{
  const EventId = 831;
  const TestId = 1;

  private $code;

  public function actionIndex($code)
  {
    $this->code = $code;

    if (\Yii::app()->getRequest()->getIsPostRequest())
    {
      $this->process();
    }

    $cs = \Yii::app()->clientScript;
    $manager = \Yii::app()->getAssetManager();
    $path = \Yii::getPathOfAlias('competence.assets');
    $cs->registerCssFile($manager->publish($path . '/css/competence.css'));
    \Yii::app()->getClientScript()->registerScriptFile($manager->publish($path . '/js/unchecker.js'), \CClientScript::POS_END);

    $this->render('index', [
      'test' => $this->getTest(),
      'questions' => $this->getQuestions()
    ]);
  }

  private $apiAccount = null;

  /**
   * @throws CHttpException
   * @return \api\models\Account
   */
  private function getApiAccount()
  {
    if ($this->apiAccount === null)
    {
      $this->apiAccount = \api\models\Account::model()->byEventId(self::EventId)->find();
      if ($this->apiAccount === null)
        throw new CHttpException(500, "Не найден API аккаунт");
    }
    return $this->apiAccount;
  }

  private  $user = null;

  private function getUser()
  {
    if ($this->user === null)
    {
      $criteria = new CDbCriteria();
      $criteria->addCondition('t."ExternalId" LIKE :Code');
      $criteria->params = ['Code' => $this->code . '%'];

      $externalUser = \api\models\ExternalUser::model()
        ->byPartner($this->getApiAccount()->Role)->find($criteria);
      if ($externalUser === null)
        throw new CHttpException(404);

      $this->user = $externalUser->User;
      if ($this->user === null)
        throw new CHttpException(404);
    }
    return $this->user;
  }

  private $test = null;

  public function getTest()
  {
    if ($this->test === null)
    {
      $this->test = \competence\models\Test::model()->findByPk(7);
      if ($this->test === null)
        throw new CHttpException(404);
      $this->test->setUser($this->getUser());
    }
    return $this->test;
  }

  /** @var \competence\models\Question[] */
  private $questions = null;

  private function getQuestions()
  {
    if ($this->questions === null)
    {
      $this->questions = [];
      $question = $this->getTest()->getFirstQuestion();
      while(true)
      {
        $this->questions[] = $question;
        /** @var \competence\models\Question $question */
        $question = $question->getForm()->getNext();
        if ($question == null)
          break;
        $question->setTest($this->getTest());
      }
    }
    return $this->questions;
  }

  private function process()
  {

  }
}