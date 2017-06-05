<?php
use application\components\controllers\MainController;
use competence\models\form\event\CodeValidation;
use competence\models\Question;
use competence\models\Result;
use competence\models\Test;
use event\models\Event;
use event\models\Participant;
use user\models\User;

/**
 * Class MSController Опросы для Miscrosoft, голосование, в которых доступно по коду
 */
class EventController extends MainController
{
    CONST START_ACTION_NAME = 'index';
    CONST END_ACTION_NAME = 'done';

    public $layout = '/event/layout';

    /**
     * @var Event
     */
    private $event;

    /**
     * @var Test
     */
    private $test;

    /**
     * @inheritdoc
     */
    protected function beforeAction($action)
    {
        $request = Yii::app()->getRequest();
        $this->event = Event::model()->byIdName($request->getParam('eventIdName'))->byDeleted(false)->find();
        if ($this->event === null) {
            throw new CHttpException(404);
        }

        $this->test = Test::model()->byEnable(true)->byParticipantsOnly(true)->byEventId($this->event->Id)->find();
        if ($this->test === null) {
            throw new CHttpException(404);
        }

        if ($this->checkExistsResult()) {
            if ($action->getId() != self::END_ACTION_NAME) {
                $this->redirect([self::END_ACTION_NAME, 'eventIdName' => $this->event->IdName]);
            }
        } else {
            if ($action->getId() != static::START_ACTION_NAME) {
                if (($this->getUser() === null || !$this->checkStartTest() || !$this->checkEndTest())) {
                    $this->redirect([self::START_ACTION_NAME, 'eventIdName' => $this->event->IdName]);
                }
            } elseif ($this->getUser() !== null && !$this->checkParticipant()) {
                throw new CHttpException(404);
            }
        }

        return parent::beforeAction($action);
    }

    /**
     * Проверяет открылось голосование
     * @return bool
     */
    private function checkStartTest()
    {
        return (empty($this->test->StartTime) || $this->test->StartTime < date('Y-m-d H:i:s'));
    }

    /**
     * Проверяет не закрылось голосование
     * @return bool
     */
    private function checkEndTest()
    {
        return (empty($this->test->EndTime) || $this->test->EndTime > date('Y-m-d H:i:s'));
    }

    /**
     * Проверяет заполнял ли участник опрос
     * @return bool
     */
    private function checkExistsResult()
    {
        if ($this->getUser() !== null && !$this->test->Multiple) {
            return Result::model()->byFinished(true)->byUserId($this->getUser()->Id)->byTestId($this->test->Id)->find();
        }
        return false;
    }

    /**
     * Проверяет является ли пользователь участником мероприятия
     * @return bool
     */
    private function checkParticipant()
    {
        if ($this->getUser() !== null) {
            return Participant::model()->byUserId($this->getUser()->Id)->byEventId($this->event->Id)->exists();
        }
        return false;
    }

    /**
     * @return User|null
     */
    public function getUser()
    {
        if (\Yii::app()->user->getCurrentUser() !== null) {
            return \Yii::app()->user->getCurrentUser();
        } elseif (\Yii::app()->tempUser->getCurrentUser() !== null) {
            return \Yii::app()->tempUser->getCurrentUser();
        }
        return null;
    }

    /**
     * Список вопросов
     * @return Question[]
     * @throws \application\components\Exception
     */
    private function getQuestions()
    {
        $questions = [];
        $question = $this->test->getFirstQuestion();
        while (true) {
            $questions[] = $question;
            /** @var \competence\models\Question $question */
            $question = $question->getForm()->getNext();
            if ($question == null) {
                break;
            }
            $question->setTest($this->test);
        }
        return $questions;
    }

    /**
     * @return Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @return Test
     */
    public function getTest()
    {
        return $this->test;
    }

    /**
     * @inheritdoc
     */
    protected function initResources()
    {
        parent::initResources();
        $clientScript = \Yii::app()->getClientScript();
        $clientScript->registerPackage('runetid.bootstrap');
        $clientScript->registerCssFile('/stylesheets/application.css');
    }

    /**
     *
     */
    public function actionIndex()
    {
        $request = \Yii::app()->getRequest();
        $form = new CodeValidation($this->test);
        if ($request->getIsPostRequest()) {
            $form->fillFromPost();
            if ($form->process()) {
                $this->redirect(['process', 'eventIdName' => $this->event->IdName]);
            }
        }

        $viewName = 'index';
        if (!$this->checkStartTest()) {
            $viewName = 'before';
        } elseif (!$this->checkEndTest()) {
            $viewName = 'after';
        }

        $this->render($viewName, [
            'event' => $this->event,
            'user' => $this->getUser(),
            'test' => $this->test,
            'form' => $form
        ]);
    }

    /**
     * Страница опроса, с сохранением результа
     */
    public function actionProcess()
    {
        $request = \Yii::app()->getRequest();

        $this->test->setUser($this->getUser());
        $questions = $this->getQuestions();

        $hasErrors = false;
        if ($request->getIsPostRequest()) {
            foreach ($questions as $question) {
                $form = $question->getForm();
                $form->setAttributes($request->getParam(get_class($form)), false);
                if (!$form->process(true)) {
                    $hasErrors = true;
                }
            }

            if (!$hasErrors) {
                $this->test->saveResult();
                $this->redirect([self::END_ACTION_NAME, 'eventIdName' => $this->event->IdName]);
            }
        }

        $this->render('process', [
            'event' => $this->event,
            'user' => $this->getUser(),
            'test' => $this->test,
            'questions' => $questions,
            'hasErrors' => $hasErrors
        ]);
    }

    /**
     * Страница с благодарностью за голосование
     */
    public function actionDone()
    {
        $this->render('done', [
            'event' => $this->event,
            'user' => $this->getUser(),
            'test' => $this->test
        ]);
    }
}
