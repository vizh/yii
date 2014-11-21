<?php

use competence\models\Result;
use event\models\section\Section;
use event\models\section\Vote;
use main\models\forms\CodeValidation;
use user\models\User;

class Appday14Controller extends \application\components\controllers\MainController
{
    public $layout = '/appday14/layout';

    public $title = 'Анкета участника';

    /** @var User */
    private $user = null;

    const EventId = 1369;
    const TestId = 16;

    protected function beforeAction($action)
    {
        $this->setPageTitle('Russian App Day 2014 - Анкета участника');
        $path = \Yii::getPathOfAlias($this->module->name . '.assets.css') . DIRECTORY_SEPARATOR;
        $path .= 'devcon.css';
        $path = \Yii::app()->assetManager->publish($path);
        \Yii::app()->clientScript->registerCssFile($path);

        $test = Yii::app()->getRequest()->getParam('test');
        if (date('Y-m-d H:i:s') < '2014-11-21 10:00:00' && !$test) {
            $this->render('before');
            return false;
        }

        if ($action->id != 'index') {
            $form = new CodeValidation(self::EventId);
            $form->code = $this->getCode();
            if (!$form->validate()) {
                $this->redirect($this->createUrl('/main/appday14/index'));
            }
            $this->user = $form->getUser();
        }



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
        $messageCode = Yii::app()->user->getFlash('Appday14Message');
        $result = Result::model()->byTestId($this->getTest()->Id)
            ->byUserId($this->user->Id)->byFinished(true)->find();

        $this->render('select', [
            'user' => $this->user,
            'messageCode' => $messageCode,
            'result' => $result
        ]);
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
            Yii::app()->user->setFlash('Appday14Message', 'FormOK');
            $this->redirect($this->createUrl('/main/appday14/select'));
        }
        return $hasErrors;
    }

    private $voteValues = ['0' => '-', '9' => 9, '8' => 8, '7' => 7, '6' => 6, '5' => 5, '4' => 4, '3' => 3, '2' => 2, '1' => 1];

    public function actionSection()
    {
        $this->title = 'Голосование за доклады';
        $currentTime = date('Y-m-d H:i:s');

        $criteria = new CDbCriteria();
        $criteria->addCondition('t."StartTime" < :CurrentTime');
        $criteria->params = ['CurrentTime' => $currentTime];
        $criteria->with = ['LinkHalls' => ['together' => true]];
        $criteria->order = 't."StartTime" DESC, "LinkHalls"."HallId"';
        $criteria->limit = 6;


        $sections = Section::model()->byEventId(self::EventId)->findAll($criteria);
        $sectionsByTime = [];
        $sectionsId = [];
        foreach ($sections as $section) {
            $sectionsByTime[$section->StartTime][] = $section;
            $sectionsId[] = $section->Id;
        }

        $sectionsByTime = array_reverse($sectionsByTime);

        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $this->saveSectionsVotes($sections);
        }

        $votes = Vote::model()->byUserId($this->user->Id)->bySectionId($sectionsId)->findAll(['index' => 'SectionId']);

        $this->render('section', [
            'sectionsByTime' => $sectionsByTime,
            'voteValues' => $this->voteValues,
            'votes' => $votes
        ]);
    }

    /**
     * @param Section[] $sections
     */
    private function saveSectionsVotes($sections)
    {
        $voteData = Yii::app()->getRequest()->getParam('vote');

        foreach ($sections as $section) {
            if (isset($voteData[$section->Id])) {
                $vote = Vote::model()->bySectionId($section->Id)->byUserId($this->user->Id)->find();
                if ($vote == null) {
                    $vote = new Vote();
                    $vote->SectionId = $section->Id;
                    $vote->UserId = $this->user->Id;
                }
                $vote->SpeakerSkill = $this->filterVoteValue($voteData[$section->Id]['SpeakerSkill']);
                $vote->save();
            }
        }

        Yii::app()->user->setFlash('Appday14Message', 'VoteOK');
        $this->redirect($this->createUrl('/main/appday14/select'));
    }

    /**
     * @param string $value
     * @return int|null
     */
    private function filterVoteValue($value)
    {
        if (!isset($this->voteValues[$value]) || $value == 0) {
            return null;
        }
        return intval($value);
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
