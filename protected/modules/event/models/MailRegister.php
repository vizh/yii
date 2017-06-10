<?php
namespace event\models;

use application\components\utility\Texts;
use mail\models\Layout;
use Yii;

class MailRegister
{
    public $Id;
    public $Body;
    public $BodyRendered;
    public $Subject;
    public $Roles = [];
    public $RolesExcept = [];
    public $SendPassbook = true;
    public $Layout = Layout::OneColumn;
    public $SendTicket = true;

    protected $eventIdName;

    public function __construct(Event $event)
    {
        $this->Id = Texts::GenerateString(5, true);
        $this->eventIdName = mb_strtolower($event->IdName);
        if (!file_exists($this->getViewDirPath())) {
            mkdir($this->getViewDirPath());
        }
    }

    protected function getViewDirPathName()
    {
        return 'event.views.mail.register.'.$this->eventIdName;
    }

    public function getViewDirPath()
    {
        return Yii::getPathOfAlias($this->getViewDirPathName());
    }

    public function getViewName()
    {
        return $this->getViewDirPathName().'.'.$this->eventIdName.'-'.$this->Id;
    }

    public function getViewPath()
    {
        return Yii::getPathOfAlias($this->getViewName()).'.php';
    }

    /**
     * @return Role[]
     */
    public function getRoles()
    {
        return $this->getRolesByList($this->Roles);
    }

    /**
     * @return Role[]
     */
    public function getRolesExcept()
    {
        return $this->getRolesByList($this->RolesExcept);
    }

    /**
     * @param int[] $roleIdList
     * @return Role[]
     */
    private function getRolesByList($roleIdList)
    {
        $criteria = new \CDbCriteria();
        $criteria->addInCondition('"t"."Id"', $roleIdList);

        return \event\models\Role::model()->findAll($criteria);
    }
}