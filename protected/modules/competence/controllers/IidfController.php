<?php

use application\components\auth\identity\RunetId;
use application\components\controllers\BaseController;
use competence\models\Question;
use competence\models\Test;
use user\models\User;

/**
 * Class MSController Опросы для Miscrosoft, голосование, в которых доступно по коду
 */
class IidfController extends BaseController
{
    CONST START_ACTION_NAME = 'index';
    CONST END_ACTION_NAME = 'done';

    public $layout = '/iidf/layout';

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
        $code = $request->getParam('code');
        $this->test = Test::model()->byEnable(true)->byCode($code)->find();
        if ($this->test === null) {
            throw new CHttpException(404);
        }

        if ($action->getId() != static::START_ACTION_NAME) {
            if (($this->getUser() === null || !$this->checkStartTest() || !$this->checkEndTest())) {
                $this->redirect([self::START_ACTION_NAME, 'code' => $code]);
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
     * Создает временного пользователя для прохождения опроса
     * @throws CException
     */
    private function createFakeUser()
    {
        $user = new User();
        $user->Email = CText::generateFakeEmail('iidf-vote');
        $user->LastName = $user->FirstName = '';
        $user->Temporary = true;
        $user->Visible = false;
        $user->register(false);
        $identity = new RunetId($user->RunetId);
        $identity->authenticate();
        if ($identity->errorCode === \CUserIdentity::ERROR_NONE) {
            Yii::app()->getUser()->login($identity);
        }
    }

    /**
     * @return User|null
     */
    public function getUser()
    {
        return Yii::app()->user->getCurrentUser();
    }

    /**
     * Список вопросов
     * @return Question[]
     * @throws Exception
     */
    private function getQuestions()
    {
        $questions = [];
        $question = $this->test->getFirstQuestion();

        while (true) {
            $questions[] = $question;
            /** @var Question $question */
            if (!$question = $question->getForm()->getNext()) {
                break;
            }

            $question->setTest($this->test);
        }

        return $questions;
    }

    /**
     * @return Test
     */
    public function getTest()
    {
        return $this->test;
    }

    /**
     *
     */
    protected function initResources()
    {
        Yii::app()->getClientScript()->registerPackage('bootstrap3');
        parent::initResources();
    }

    /**
     * Страница опроса, с сохранением результа
     */
    public function actionIndex()
    {
        if (!$this->getUser()) {
            $this->createFakeUser();
        }

        $request = Yii::app()->getRequest();
        $questions = $this->getQuestions();
        $hasErrors = false;
        if ($request->getIsPostRequest()) {
            $this->test->setUser($this->getUser());
            foreach ($questions as $question) {
                $form = $question->getForm();
                $form->setAttributes($request->getParam(get_class($form)), false);
                if (!$form->process(true)) {
                    $hasErrors = true;
                }
            }

            if (!$hasErrors) {
                $this->test->saveResult();
                $this->redirect([self::END_ACTION_NAME, 'code' => $this->test->Code]);
            }
        }

        $this->render('index', [
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
        Yii::app()->getUser()->logout();
        Yii::app()->getClientScript()->registerMetaTag(
            '10; url='.$this->createUrl('index', ['code' => $this->test->Code]), null, 'refresh'
        );
        $this->render('done', [
            'test' => $this->test
        ]);
    }
}
