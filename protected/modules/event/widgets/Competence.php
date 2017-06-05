<?php
namespace event\widgets;

use competence\models\Result;
use competence\models\Test;
use event\components\Widget;
use event\components\WidgetPosition;
use event\models\Role;

/**
 * Class Competence
 * @package event\widgets
 *
 * @property int $WidgetCompetenceTestId
 * @property string $WidgetCompetenceErrorKeyMessage
 * @property string $WidgetCompetenceNotAuthMessage
 * @property string $WidgetCompetenceHasResultMessage
 * @property int $WidgetCompetenceRoleIdAfter
 */
class Competence extends Widget
{
    public function getAttributeNames()
    {
        return [
            'WidgetCompetenceTestId',
            'WidgetCompetenceNotAuthMessage',
            'WidgetCompetenceHasResultMessage',
            'WidgetCompetenceRoleIdAfter'
        ];
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return \Yii::t('app', 'Опрос на странице мероприятия');
    }

    private $position = null;

    /**
     * @return string
     */
    public function getPosition()
    {
        return WidgetPosition::Content;
    }

    private $test = null;

    /**
     * @return Test|null
     */
    public function getTest()
    {
        if ($this->test === null) {
            $this->test = Test::model()->findByPk($this->WidgetCompetenceTestId);
            if ($this->getUser() !== null && $this->test !== null) {
                $this->test->setUser($this->getUser());
            }
        }
        return $this->test;
    }

    /** @var \competence\models\Question[] */
    public $questions = [];

    public function init()
    {
        parent::init();
        if ($this->getTest() === null) {
            return;
        }

        $question = $this->getTest()->getFirstQuestion();
        while (true) {
            $this->questions[] = $question;
            /** @var \competence\models\Question $question */
            $question = $question->getForm()->getNext();
            if ($question == null) {
                break;
            }
            $question->setTest($this->getTest());
        }
    }

    public function process()
    {
        $request = \Yii::app()->getRequest();
        $test = $request->getParam('CompetenceTest');
        if ($request->getIsPostRequest() && $test !== null && !empty($this->questions)) {
            $hasErrors = false;
            foreach ($this->questions as $question) {
                $form = $question->getForm();
                $form->setAttributes($request->getParam(get_class($form)), false);
                if (!$form->process()) {
                    $hasErrors = true;
                }
            }

            if (!$hasErrors) {
                $this->getTest()->saveResult();
                $this->registerUserOnEvent();
                $this->getController()->redirect(['/event/view/index', 'idName' => $this->event->IdName]);
            }
        }
    }

    /**
     * Регистрирует пользователя на мероприятие
     * @throws \application\components\Exception
     */
    private function registerUserOnEvent()
    {
        if (!isset($this->WidgetCompetenceRoleIdAfter)) {
            $role = Role::model()->findByPk($this->WidgetCompetenceRoleIdAfter);
            if (!empty($this->getEvent()->Parts)) {
                $this->getEvent()->registerUserOnAllParts($this->getUser(), $role);
            } else {
                $this->getEvent()->registerUser($this->getUser(), $role);
            }
        }
    }

    public function run()
    {
        if ($this->getTest() === null) {
            return;
        }

        if ($this->getUser() === null) {
            $this->render('competence/not-auth');
            return;
        }

        $hasResult = Result::model()->byTestId($this->getTest()->Id)->byUserId($this->getUser()->Id)->byFinished(true)->exists();
        if ($hasResult) {
            $this->render('competence/has-result');
            return;
        }
        $this->render('competence', ['test' => $this->getTest()]);
    }

    protected function registerDefaultResources()
    {
        $assetManager = \Yii::app()->getAssetManager();
        $path = \Yii::getPathOfAlias('competence.assets');
        \Yii::app()->getClientScript()->registerCssFile($assetManager->publish($path.'/css/module.css'));
        \Yii::app()->getClientScript()->registerScriptFile($assetManager->publish($path.'/js/module.js'), \CClientScript::POS_END);
        parent::registerDefaultResources();
    }

    /**
     * Указывает на наличие ресурсов у виджета.
     * Если значение false, метод @see \event\components\Widget::registerDefaultResources() вызван не будет
     * @return bool
     */
    public function getIsHasDefaultResources()
    {
        return true;
    }

}