<?php

namespace partner\components;

use application\components\Exception;
use application\components\utility\Texts;
use CClientScript;
use ReflectionMethod;
use ruvents\models\Account;
use Yii;

/**
 * @method Controller getController()
 */
class Action extends \CAction
{
    /**
     * Позволяет запускать методы вида runAjax{ActionName} если строка запроса содержит параметр ajaxAction
     *
     * @param array $params
     *
     * @return bool
     */
    public function runWithParams($params)
    {
        $ajaxAction = Yii::app()
            ->getRequest()
            ->getParam('ajaxAction');

        if ($ajaxAction === null) {
            return parent::runWithParams($params);
        }

        try {
            $method = new ReflectionMethod($this, 'runAjax'.ucfirst($ajaxAction));
            $method->invoke($this);
        } catch (Exception $e) {
            $this->renderJson($e->getMessage());
        } catch (\Exception $e) {
            $this->renderJson(['Error' => ['Code' => $e->getCode(), 'Message' => $e->getMessage()]]);
        }

        return true;
    }

    /**
     * @return \event\models\Event
     */
    public function getEvent()
    {
        return $this->getController()->getEvent();
    }

    /**
     * Возвращает Account для Ruvents. Если аккаунта нет, то создает его.
     *
     * @return Account
     */
    public function getRuventsAccount()
    {
        $account = Account::model()
            ->byEventId($this->getEvent()->Id)
            ->find();

        if ($account === null) {
            $account = new Account();
            $account->EventId = $this->getEvent()->Id;
            $account->Hash = Texts::GenerateString(25);
            $account->save();
        }

        return $account;
    }

    /**
     * Инициализирует глобальную переменную с именем $name и указанным содержимым
     *
     * @param string $name
     * @param mixed  $data
     */
    public function addScriptData($name, $data)
    {
        Yii::app()->getClientScript()->registerScript(
            "ScriptData_{$name}",
            "var {$name} = ".json_encode($data, JSON_UNESCAPED_UNICODE).';',
            CClientScript::POS_HEAD
        );
    }

    public function renderSuccessJson($message = 'Готово!')
    {
        $this->renderJson(['Success' => true, 'Message' => $message]);
    }

    public function renderJson($data)
    {
        if (is_string($data)) {
            echo $data;
        } else {
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }
    }
}
