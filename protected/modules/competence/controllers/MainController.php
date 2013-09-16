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

    if (\Yii::app()->user->getCurrentUser() == null)
    {
      $this->render('competence.views.system.unregister');
      return false;
    }

    if (!$this->getTest()->Test)
    {
      $result = \competence\models\Result::model()
          ->byTestId($this->getTest()->Id)->byUserId(\Yii::app()->user->getCurrentUser()->Id)->find();
      if ($result != null && $action->getId() != 'end' && $action->getId() != 'done')
      {
        $this->redirect(\Yii::app()->createUrl('/competence/main/done', ['id' => $this->getTest()->Id]));
      }
    }

    return parent::beforeAction($action);
  }


  public function actionIndex($id)
  {
    $this->setPageTitle(strip_tags($this->getTest()->Title));
    if (\Yii::app()->request->getIsPostRequest())
    {
      if ($this->getTest()->Test)
      {
        $this->test->getFirstQuestion()->clearFullData();
        $this->test->getFirstQuestion()->clearRotation();
      }
      $this->redirect($this->createUrl('/competence/main/process', array('id'=>$id)));
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