<?php
namespace partner\components;

use application\components\Exception;

class WebUser extends \CWebUser
{
    /** @var \partner\models\Account */
    private $account = null;

    /**
     * @return \partner\models\Account
     */
    public function getAccount()
    {
        if ($this->account === null && !\Yii::app()->partner->getIsGuest())
        {
            $this->account = \partner\models\Account::model()->findByPk(\Yii::app()->partner->getId());
        }

        return $this->account;
    }


    protected $event = null;

    /**
     * @throws \application\components\Exception
     * @return \event\models\Event
     */
    public function getEvent()
    {
        if ($this->event === null)
        {
            if ($this->getAccount() !== null)
            {
                if (!$this->getAccount()->getIsExtended())
                {
                    $this->event = \event\models\Event::model()->findByPk($this->getAccount()->EventId);
                }
                else
                {
                    $eventId = \Yii::app()->getSession()->get('PartnerAccountEventId');
                    if ($eventId !== null)
                    {
                        $this->event = \event\models\Event::model()->findByPk($eventId);
                        $this->getAccount()->EventId = $eventId;
                    }
                    else
                    {
                        return null;
                    }
                }
            }

            if ($this->event === null)
            {
                throw new Exception('Не найдено мероприятие для данного пользователя партнерского интерфейса');
            }
        }

        return $this->event;
    }

    /**
     * Задано ли мероприятие для партнерского интерфейса
     * @return bool
     */
    public function getIsSetEvent()
    {
        try {
            $event = $this->getEvent();
            return !empty($event);
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @return null|string
     */
    public function getRole()
    {
        if ($this->getAccount() !== null)
        {
            return $this->getAccount()->Role;
        }
        return null;
    }

    protected $_access = array();

    public function checkAccess($operation,$params=array(),$allowCaching=true)
    {
        if($allowCaching && $params===array() && isset($this->_access[$operation]))
            return $this->_access[$operation];
        else
            return $this->_access[$operation]= \Yii::app()->partnerAuthManager->checkAccess($operation,$this->getId(),$params);
    }
}