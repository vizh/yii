<?php

use application\components\auth\identity\RunetId;
use application\components\controllers\PublicMainController;
use competence\models\Result;
use competence\models\Test;
use competence\models\Question;
use event\models\Participant;
use user\models\User;
use application\components\exception\AuthException;

/**
 * Class MainController
 */
class MainController extends PublicMainController
{
    // Identifier of the done action
    CONST END_ACTION_NAME = 'done';

    /**
     * @inheritdoc
     */
    public $layout = '/layouts/public';

    /**
     * @var Test
     */
    public $test;

    /**
     * @var Question
     */
    public $question;

    /**
     * Adds params for fath auth after a redirect
     * @inheritdoc
     */
    public function redirect($url, $terminate = true, $statusCode = 302)
    {
        $runetId = Yii::app()->getRequest()->getParam('runetId');
        $hash = Yii::app()->getRequest()->getParam('hash');

        if (is_array($url) && !$runetId && !$hash) {
            $url['runetId'] = $runetId;
            $url['hash'] = $hash;
        }

        parent::redirect($url, $terminate, $statusCode);
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'process' => 'competence\controllers\main\ProcessAction',
        ];
    }

    /**
     * @return Test
     */
    public function getTest()
    {
        if (is_null($this->test)) {
            $this->test = Test::model()->findByPk($this->actionParams['id']);
        }

        return $this->test;
    }

    /**
     * Shows the page with the test
     * @param int $id Identifier of the test
     */
    public function actionIndex($id)
    {
        $this->setPageTitle(strip_tags($this->getTest()->Title));

        if (Yii::app()->request->getIsPostRequest()) {
            if ($this->getTest()->Test) {
                $this->test->getFirstQuestion()->getForm()->clearResult();
                $this->test->getFirstQuestion()->getForm()->clearRotation();
            }
            $this->redirect($this->createUrl('/competence/main/process', ['id' => $id]));
        }

        $this->render('index', [
            'test' => $this->getTest(),
        ]);
    }

    /**
     * Shows the page with all questions from the test
     * @param int $id Identifier of the test
     */
    public function actionAll($id)
    {
        $request = \Yii::app()->getRequest();

        $this->test->setUser($this->getUser());
        $questions = $this->getQuestions();

        $hasErrors = false;
        if ($request->isPostRequest) {
            foreach ($questions as $question) {
                $form = $question->getForm();
                $form->setAttributes($request->getParam(get_class($form)), false);
                if (!$form->validate()) {
                    $hasErrors = true;
                }
            }

            if (!$hasErrors) {
                foreach ($questions as $question) {
                    $form = $question->getForm();
                    $form->process();
                }

                $this->test->saveResult();
                $this->redirect([self::END_ACTION_NAME, 'id' => $this->test->Id]);
            }
        }

        $this->render('all-questions', [
            'user' => $this->getUser(),
            'test' => $this->test,
            'questions' => $questions,
            'hasErrors' => $hasErrors,
        ]);
    }

    /**
     * Shows the page when the test is done
     * @param int $id
     */
    public function actionDone($id)
    {
        $this->render($this->getTest()->getEndView(), [
            'test' => $this->getTest(),
            'done' => $this->checkExistsResult(),
        ]);
    }

    /**
     * Shows the page after the test
     * @param int $id
     */
    public function actionAfter($id)
    {
        $this->render('after', ['test' => $this->getTest()]);
    }

    /**
     * Returns current user
     * @return User|null
     */
    public function getUser()
    {
        if (Yii::app()->user->getCurrentUser() !== null) {
            return Yii::app()->user->getCurrentUser();
        } elseif (Yii::app()->tempUser->getCurrentUser() !== null) {
            return Yii::app()->tempUser->getCurrentUser();
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    protected function beforeAction($action)
    {
        $this->fastAuth();

        $test = $this->getTest();
        if (is_null($test) || !$test->Enable) {
            throw new CHttpException(404);
        }

        if ($test->ParticipantsOnly && $test->EventId) {
            $participantExists = Participant::model()->exists('"EventId" = :eventId AND "UserId" = :userId', [
                ':eventId' => $test->EventId,
                ':userId' => Yii::app()->getUser()->id,
            ]);

            if (!$participantExists) {
                throw new CHttpException(404);
            }
        }

        if ($this->getTest()->getUserKey() == null && Yii::app()->user->getCurrentUser() == null) {
            $this->render('competence.views.system.unregister');

            return false;
        }

        if ($this->checkExistsResult() && $action->getId() != 'done') {
            $this->redirect(['done', 'id' => $this->getTest()->Id]);
        }

        if (!empty($this->getTest()->EndTime) && $this->test->EndTime < date('Y-m-d H:i:s') && $action->getId() != 'after') {
            $this->redirect(['after', 'id' => $this->getTest()->Id]);
        }

        $this->getTest()->setUser(Yii::app()->user->getCurrentUser());

        return parent::beforeAction($action);
    }

    /**
     * Проверяет проходил ли пользователь опрос
     * @return bool
     */
    private function checkExistsResult()
    {
        if (!$this->getTest()->Test && !$this->getTest()->Multiple) {
            $model = Result::model()->byTestId($this->getTest()->Id)->byFinished();
            if ($this->getTest()->getUserKey() !== null) {
                $model->byUserKey($this->getTest()->getUserKey());
            } else {
                $model->byUserId($this->getUser()->Id);
            }

            return $model->exists();
        }

        return false;
    }

    /**
     * Returns questions list
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
            $question = $question->getForm()->getNext();
            if ($question == null) {
                break;
            }

            $question->setTest($this->test);
        }

        return $questions;
    }

    /**
     * Performs fast authentication
     */
    private function fastAuth()
    {
        $runetId = Yii::app()->getRequest()->getParam('runetId');
        $hash = Yii::app()->getRequest()->getParam('hash');

        if (!$runetId && !$hash) {
            return;
        }

        try {
            $user = User::model()
                ->byRunetId($runetId)
                ->find();

            if ($user === null) {
                throw new AuthException("User with RunetId = $runetId is not found");
            }

            if ($user->getHash(false) !== $hash) {
                throw new AuthException('Hash is invalid');
            }

            $identity = new RunetId($user->RunetId);
            $identity->authenticate();

            if ($identity->errorCode !== \CUserIdentity::ERROR_NONE) {
                Yii::log("Error occurs while authentication process code: {$identity->errorCode}");
                return;
            }

            if ($user->Temporary === false) {
                Yii::app()->user->login($identity);

                return;
            }

            if (Yii::app()->user->isGuest === false) {
                Yii::app()->user->logout();
            }

            Yii::app()->tempUser->login($identity);
        } catch (AuthException $e) {
        }
    }
}
