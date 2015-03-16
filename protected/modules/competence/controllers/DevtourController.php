<?php
use application\components\controllers\MainController;

use event\models\Event;
use competence\models\Result;
use competence\models\Test;

class DevtourController extends MainController
{
    const EVENT_ID = 1715;

    public $layout = '/event/layout';

    public function actionIndex()
    {
        $user = $this->getUser();
        if ($user === null) {
            throw new \CHttpException(404);
        }

        $result = Result::model()->byUserId($user->Id)->byFinished(true)->byTestId($this->getTest()->Id)->find();

        $this->render('index', [
            'user' => $user,
            'result' => $result,
            'event' => $this->getEvent()
        ]);
    }

    /**
     * @return null|\user\models\User
     */
    private function getUser()
    {
        if (\Yii::app()->user->getCurrentUser() !== null) {
            return \Yii::app()->user->getCurrentUser();
        }
        elseif (\Yii::app()->tempUser->getCurrentUser() !== null) {
            return \Yii::app()->tempUser->getCurrentUser();
        }
        return null;
    }


    private $event = null;

    /**
     * @return Event|null
     */
    public function getEvent()
    {
        if ($this->event === null) {
            $this->event = Event::model()->findByPk(self::EVENT_ID);
        }
        return $this->event;
    }

    /**
     * @return Test
     */
    public function getTest()
    {
        return Test::model()->byEventId($this->getEvent()->Id)->byEnable(true)->find();
    }

    protected function initResources()
    {
        parent::initResources();
        $clientScript = \Yii::app()->getClientScript();
        $clientScript->registerPackage('runetid.bootstrap');
        $clientScript->registerCssFile('/stylesheets/application.css');
    }
} 