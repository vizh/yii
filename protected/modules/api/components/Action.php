<?php
namespace api\components;

class Action extends \CAction
{
    /**
     * @return Controller
     */
    public function getController()
    {
        return parent::getController();
    }

    /**
     * @return \api\models\Account
     */
    public function getAccount()
    {
        return $this->getController()->getAccount();
    }

    /**
     * @return builders\Builder
     */
    public function getDataBuilder()
    {
        return $this->getAccount()->getDataBuilder();
    }

    /**
     * @throws Exception
     * @return \event\models\Event
     */
    public function getEvent()
    {
        if ($this->getAccount()->Event == null) {
            throw new \api\components\Exception(301);
        }
        return $this->getAccount()->Event;
    }

    /**
     * @param mixed $result
     */
    public function setResult($result)
    {
        $this->getController()->setResult($result);
    }

    /**
     * @return int
     */
    protected function getMaxResults()
    {
        return \Yii::app()->params['ApiMaxResults'];
    }
}
