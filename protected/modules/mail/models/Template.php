<?php
namespace mail\models;
use event\models\Event;
use mail\components\mailers\MandrillMailer;
use mail\components\mailers\PhpMailer;

/**
 * Class Template
 * @package mail\models
 *
 * @property int $Id
 * @property string $Filter
 * @property string $Title
 * @property string $Subject
 * @property string $From
 * @property string $FromName
 * @property bool $SendPassbook
 * @property bool $SendUnsubscribe
 * @property bool $Active
 * @property string $ActivateTime
 * @property bool $Success
 * @property string $SuccessTime
 * @property string $ViewHash
 * @property string $CreationTime
 * @property int $LastUserId;
 * @property bool $SendInvisible;
 * @property bool $ShowUnsubscribeLink
 * @property bool $ShowFooter
 * @property string $Layout
 * @property int $RelatedEventId;
 *
 * @property Event $RelatedEvent;
 */
class Template extends \CActiveRecord
{
    const UsersPerSend = 200;

    private $testMode  = false;
    private $testUsers = [];

    /**
     * @param string $className
     *
     * @return Template
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'MailTemplate';
    }

    public function primaryKey()
    {
        return 'Id';
    }

    /**
     * @return array
     */
    public function relations()
    {
        return [
            'RelatedEvent' => [self::BELONGS_TO, '\event\models\Event', 'RelatedEventId']
        ];
    }

    public function send()
    {
        if (!$this->Success)
        {
            if (!$this->getIsTestMode())
            {
                $mails = [];
                foreach ($this->getUsers() as $user)
                {
                    $mails[] = new \mail\components\mail\Template($this->getMailer(), $user, $this);
                }
                if (!empty($mails))
                {
                    $this->getMailer()->send($mails);
                }
            }
            else
            {
                foreach ($this->testUsers as $user)
                {
                    $criteria = new \CDbCriteria();
                    $criteria->addCondition('"t"."Id" = :UserId');
                    $criteria->params['UserId'] = $user->Id;
                    $criteria->mergeWith($this->getCriteria());
                    $recipient = \user\models\User::model()->find($criteria);
                    $mail = new \mail\components\mail\Template($this->getMailer(),$recipient,$this);
                    $this->getMailer()->send([$mail]);
                }
            }
        }
    }

    /**
     * @throws \Exception
     * @return \user\models\User[]
     */
    public function getUsers()
    {
        $transaction = \Yii::app()->getDb()->beginTransaction();
        try {
            \Yii::app()->getDb()->createCommand('LOCK TABLE "MailTemplate" IN ACCESS EXCLUSIVE MODE;')->execute();
            $this->refresh();
            $criteria = $this->getCriteria();
            $criteria->limit = $this->SendPassbook ? 1 : self::UsersPerSend;
            $users = \user\models\User::model()->findAll($criteria);
            if (empty($users)) {
                $this->Success = true;
                $this->SuccessTime = date('Y-m-d H:i:s');
            } else {
                $this->LastUserId = $users[sizeof($users)-1]->Id;
            }
            $this->save();
            $transaction->commit();
            return $users;
        } catch (\Exception $e) {
            $transaction->rollback();
            throw $e;
        }
    }

    /**
     * @return \CDbCriteria
     */
    public function getCriteria($all = false)
    {
        $criteria = new \CDbCriteria();
        $criteria->with = ['Settings'];
        $criteria->order = '"t"."Id" ASC';
        $criteria->addCondition('"t"."Email" != \'\'');

        if (!$this->getIsTestMode())
        {
            if (!$this->SendUnsubscribe)
            {
                $criteria->addCondition('NOT "Settings"."UnsubscribeAll"');
                if (!empty($this->RelatedEventId)) {
                    $criteria->addCondition('"t"."Id" NOT IN (SELECT "UserId" FROM "UserUnsubscribeEventMail" WHERE "EventId" = :RelativeEventId)');
                    $criteria->params['RelativeEventId'] = $this->RelatedEventId;
                }
            }

            if (!$this->SendInvisible)
            {
                $criteria->addCondition('"t"."Visible"');
            }
        }

        if (!$this->getIsTestMode() && !$all && $this->LastUserId !== null)
        {
            $criteria->addCondition('"t"."Id" > :LastUserId');
            $criteria->params['LastUserId'] = $this->LastUserId;
        }
        $filter = $this->getFilter();
        if (!empty($filter))
        {
            $criteria->mergeWith($filter->getCriteria());
        }
        return $criteria;
    }

    public function getViewName()
    {
        if (!$this->getIsNewRecord())
        {
            return 'mail.views.templates.template'.$this->Id;
        }
        return null;
    }

    private $viewPath = null;
    public function getViewPath()
    {
        if ($this->viewPath == null && !$this->getIsNewRecord())
        {
            $this->viewPath = \Yii::getPathOfAlias($this->getViewName()).'.php';
        }
        return $this->viewPath;
    }

    /**
     * @param bool $test
     */
    public function setTestMode($test)
    {
        $this->testMode = $test;
        if (!$test)
            $this->testUsers = [];
    }

    public function getIsTestMode()
    {
        return $this->testMode;
    }

    /**
     * @param \user\models\User[] $users
     */
    public function setTestUsers($users)
    {
        $this->testUsers = $users;
    }

    /**
     * @param bool $active
     * @param bool $useAnd
     * @return $this
     */
    public function byActive($active = true, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = ($active == false ? 'NOT ' : '').'"t"."Active"';
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     * @param bool $success
     * @param bool $useAnd
     * @return $this
     */
    public function bySuccess($success = true, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = ($success == false ? 'NOT ' : '').'"t"."Success"';
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    public function getFilter()
    {
        return unserialize(base64_decode($this->Filter));
    }

    public function setFilter($filter)
    {
        $this->Filter = base64_encode(serialize($filter));
    }

    private $mailer = null;

    /**
     * @return \mail\components\Mailer
     */
    public function getMailer()
    {
        if ($this->mailer == null)
        {
            $this->mailer = new MandrillMailer();
        }
        return $this->mailer;
    }

    /**
     * @param \user\models\User $user
     * @return array
     */
    public function getBodyVarValues(\user\models\User $user)
    {
        $controller = new \CController('default',null);
        $result = [
            $this->getMailer()->getVarNameUserUrl() => $user->getUrl(),
            $this->getMailer()->getVarNameUserRunetId() => $user->RunetId,
            $this->getMailer()->getVarNameMailBody() => $controller->renderPartial($this->getViewName(), ['user' => $user], true)
        ];
        return $result;
    }
}