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

  protected function beforeAction($action)
  {
    $cs = \Yii::app()->clientScript;
    $manager = \Yii::app()->getAssetManager();
    $path = \Yii::getPathOfAlias('competence.assets');
    $cs->registerCssFile($manager->publish($path . '/css/competence.css'));
    \Yii::app()->getClientScript()->registerScriptFile($manager->publish($path . '/js/unchecker.js'), \CClientScript::POS_END);

    $this->test = \competence\models\Test::model()->findByPk($this->actionParams['id']);
    if ($this->test == null)
      throw new \CHttpException(404);

    if (\Yii::app()->user->getCurrentUser() == null)
    {
      $this->render('competence.views.system.unregister');
      return false;
    }

//    $result = \competence\models\Result::model()
//        ->byTestId($this->test->Id)->byUserId(\Yii::app()->user->getCurrentUser()->Id)->find();
//    if ($result != null && $action->getId() != 'end' && $action->getId() != 'done')
//    {
//      $this->redirect(\Yii::app()->createUrl('/competence/main/done', ['id' => $this->test->Id]));
//    }
    return parent::beforeAction($action);
  }


  public function actionIndex($id)
  {
    if (\Yii::app()->request->getIsPostRequest())
    {
      $this->test->getFirstQuestion()->clearFullData();
      $this->test->getFirstQuestion()->clearRotation();
      $this->redirect($this->createUrl('/competence/main/process', array('id'=>$id)));
    }
    $this->render('index');
  }

  public function actionEnd($id)
  {
    $this->render('end', array('done' => false));
  }

  public function actionDone($id)
  {
    $this->render('end', array('done' => true));
  }

}