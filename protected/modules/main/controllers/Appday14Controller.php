<?php

use main\models\forms\CodeValidation;
use user\models\User;

class Appday14Controller extends \application\components\controllers\MainController
{
    public $layout = '/appday14/layout';

    /** @var User */
    private $user = null;
//
//    const EventId = 831;
//    const TestId = 7;

    const EventId = 1369;
    const TestId = 16;

    protected function beforeAction($action)
    {
        if ($action->id != 'index') {
            $form = new CodeValidation(self::EventId);
            $form->code = $this->getCode();
            if (!$form->validate()) {
                $this->redirect($this->createUrl('/main/appday14/index'));
            }
            $this->user = $form->getUser();
        }

        $path = \Yii::getPathOfAlias($this->module->name . '.assets.css') . DIRECTORY_SEPARATOR;
        $path .= 'devcon.css';
        $path = \Yii::app()->assetManager->publish($path);
        \Yii::app()->clientScript->registerCssFile($path);

        $path = \Yii::getPathOfAlias($this->module->name . '.assets.js') . DIRECTORY_SEPARATOR;
        $path .= 'devcon.js';
        $path = \Yii::app()->assetManager->publish($path);
        \Yii::app()->clientScript->registerScriptFile($path);

        return parent::beforeAction($action);
    }


    public function actionIndex()
    {
        $request = Yii::app()->getRequest();
        $form = new CodeValidation(self::EventId);

        if ($request->getIsPostRequest()) {
            $form->attributes = $request->getParam(get_class($form));
            $form->validate();
        } else {
            $code = $request->getParam('code', $this->getCode());
            if (!empty($code)) {
                $form->code = $code;
                $form->validate();
            }
        }

        if (!empty($form->code) && !$form->hasErrors()) {
            $this->setCode($form->code);
            $this->redirect($this->createUrl('/main/appday14/select'));
        }


        $this->render('index', ['form' => $form]);
    }

    public function actionSelect()
    {
        $this->render('select', ['user' => $this->user]);
    }

    public function actionForm()
    {
        $result = \competence\models\Result::model()
            ->byTestId($this->getTest()->Id)->byUserId($this->user->Id)->find();
        if ($result != null && $result->Finished) {
            $this->redirect($this->createUrl('/main/appday14/select'));
        }

        $hasErrors = false;
        if (\Yii::app()->getRequest()->getIsPostRequest()) {
            $hasErrors = $this->processForm();
        } else {
            foreach ($this->getQuestions() as $question) {
                $result = $question->getTest()->getResult()->getQuestionResult($question);
                $question->getForm()->setAttributes($result, false);
            }
        }

        $this->render('form', [
            'test' => $this->getTest(),
            'questions' => $this->getQuestions(),
            'hasErrors' => $hasErrors
        ]);
    }

    /**
     * @return bool
     */
    private function processForm()
    {
        $request = \Yii::app()->getRequest();

        $hasErrors = false;
        foreach ($this->getQuestions() as $question) {
            $form = $question->getForm();
            $form->setAttributes($request->getParam(get_class($form)), false);
            if (!$form->process(true))
                $hasErrors = true;
        }

        if (!$hasErrors) {
            $this->getTest()->saveResult();
            $this->redirect($this->createUrl('/main/appday14/select'));
        }
        return $hasErrors;
    }

    public function actionSection()
    {

    }

    public function getCode()
    {
        return Yii::app()->getSession()->get('Appday14Code');
    }

    public function setCode($code)
    {
        Yii::app()->getSession()->add('Appday14Code', $code);
    }

    private $test = null;

    public function getTest()
    {
        if ($this->test === null) {
            $this->test = \competence\models\Test::model()->findByPk(self::TestId);
            if ($this->test === null)
                throw new CHttpException(404);
            $this->test->setUser($this->user);
        }
        return $this->test;
    }

    /** @var \competence\models\Question[] */
    private $questions = null;

    private function getQuestions()
    {
        if ($this->questions === null) {
            $this->questions = [];
            $question = $this->getTest()->getFirstQuestion();
            while(true) {
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

    protected function initResources()
    {
        $clientScript = \Yii::app()->getClientScript();
        $clientScript->registerPackage('runetid.bootstrap');
        $clientScript->registerCssFile('/stylesheets/application.css');

        $manager = \Yii::app()->getAssetManager();
        $path = \Yii::getPathOfAlias('competence.assets');
        $clientScript->registerCssFile($manager->publish($path . '/css/competence.css'));
        $clientScript->registerScriptFile($manager->publish($path . '/js/unchecker.js'), \CClientScript::POS_END);

        parent::initResources();
    }
}
