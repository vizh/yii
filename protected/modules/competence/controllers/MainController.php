<?php
use application\components\controllers\PublicMainController;
use \competence\models\Result;

class MainController extends PublicMainController
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

    /**
     * @inheritdoc
     */
    protected function beforeAction($action)
    {
        if ($this->getTest() == null || !$this->getTest()->Enable) {
            throw new \CHttpException(404);
        }

        if ($this->getTest()->getUserKey() == null && \Yii::app()->user->getCurrentUser() == null) {
            $this->render('competence.views.system.unregister');
            return false;
        }

        if (!$this->getTest()->Test && !$this->getTest()->Multiple) {
            $model = Result::model()->byTestId($this->getTest()->Id)->byFinished();
            if ($this->getTest()->getUserKey() !== null) {
                $model->byUserKey($this->getTest()->getUserKey());
            }
            else {
                $model->byUserId(\Yii::app()->user->getCurrentUser()->Id);
            }
            $result = $model->find();
            if ($result != null && $action->getId() != 'end' && $action->getId() != 'done') {
                $this->redirect(\Yii::app()->createUrl('/competence/main/done', ['id' => $this->getTest()->Id]));
            }
        }

        $this->getTest()->setUser(\Yii::app()->user->getCurrentUser());
        return parent::beforeAction($action);
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