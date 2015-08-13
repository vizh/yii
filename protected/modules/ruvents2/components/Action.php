<?php

namespace ruvents2\components;

use api\models\Account;

/**
 * Class Action
 * @package ruvents2\components
 *
 * @method Controller getController()
 */
class Action extends \CAction
{
    /** @var bool|Account|null */
    private $apiAccount = false;

    /**
     * @return \ruvents\models\Operator
     */
    public function getOperator()
    {
        return $this->getController()->getOperator();
    }

    /**
     * @return \event\models\Event
     */
    public function getEvent()
    {
        return $this->getController()->getEvent();
    }

    public function renderJson($data)
    {
        $this->getController()->renderJson($data);
    }

    /**
     * @return Account|null
     */
    protected function getApiAccount()
    {
        return $this->getController()->getApiAccount();
    }
}