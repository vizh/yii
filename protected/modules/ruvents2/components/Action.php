<?php
namespace ruvents2\components;

/**
 * Class Action
 * @package ruvents2\components
 *
 * @method Controller getController()
 */
class Action extends \CAction
{
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
}