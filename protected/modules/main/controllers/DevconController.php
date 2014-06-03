<?php

class DevconController extends \application\components\controllers\MainController
{
    public $layout = "/devcon/layout";

    const EventId = 831;
    const TestId = 1;

    private $code;

    public $rulesAgree = 'yes';

    public function actionIndex($code)
    {
        $this->code = $code;

//        $test = Yii::app()->getRequest()->getParam('test');
//        if (date('Y-m-d H:i:s') < '2014-05-29 10:00:00' && empty($test)) {
//            $this->render('before', ['user' => $this->getUser()]);
//            return;
//        }

        $result = \competence\models\Result::model()
            ->byTestId($this->getTest()->Id)->byUserId($this->getUser()->Id)->find();
        if ($result != null && $result->Finished) {
            $this->redirect($this->createUrl('/main/devcon/result', ['code' => $this->code]));
        }

        $this->render('index', ['user' => $this->getUser(), 'code' => $code]);
    }

    public function actionProcess($code)
    {
        $this->code = $code;

        $result = \competence\models\Result::model()
            ->byTestId($this->getTest()->Id)->byUserId($this->getUser()->Id)->find();
        if ($result != null && $result->Finished) {
            $this->redirect($this->createUrl('/main/devcon/result', ['code' => $this->code]));
        }

        $hasErrors = false;
        if (\Yii::app()->getRequest()->getIsPostRequest())
        {
          $hasErrors = $this->process();
        }
        else
        {
          foreach ($this->getQuestions() as $question)
          {
            $result = $question->getTest()->getResult()->getQuestionResult($question);
            $question->getForm()->setAttributes($result, false);
          }
        }

        $this->render('process', [
            'test' => $this->getTest(),
            'questions' => $this->getQuestions(),
            'hasErrors' => $hasErrors
        ]);
    }

    public function actionResult($code)
    {
      $this->code = $code;
      $this->render('result');
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
            $code = substr($this->code, 0, 8);
            if (strlen($code) != 8)
                throw new CHttpException(404);

            $criteria = new CDbCriteria();
            $criteria->addCondition('t."ExternalId" LIKE :Code');
            $criteria->params = ['Code' => strtolower($code) . '%'];

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

    /**
     * @return bool
     */
    private function process()
    {
        $request = \Yii::app()->getRequest();

        $hasErrors = false;
        foreach ($this->getQuestions() as $question) {
            $form = $question->getForm();
            $form->setAttributes($request->getParam(get_class($form)), false);
            if (!$form->process(true))
                $hasErrors = true;
        }

        $this->rulesAgree = $request->getParam('DevCon2014RulesAgree');
        if ($this->rulesAgree !== 'yes') {
            $hasErrors = true;
        }

        if (!$hasErrors) {
            $this->getTest()->saveResult();

            $product = \pay\models\Product::model()->findByPk(2757);
            $orderItem = \pay\models\OrderItem::model()->byProductId($product->Id)->byOwnerId($this->getUser()->Id)->find();
            if ($orderItem == null)
            {
              $orderItem = $product->getManager()->createOrderItem($this->getUser(), $this->getUser());
              $orderItem->Paid = true;
              $orderItem->PaidTime = date('Y-m-d H:i:s');
              $orderItem->save();
            }
            $this->redirect($this->createUrl('/main/devcon/result', ['code' => $this->code]));
            $this->refresh();
        }
        return $hasErrors;
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