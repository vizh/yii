<?php
namespace mail\models;

use application\components\ActiveRecord;
use event\models\Event;
use mail\components\filter\Main;
use mail\components\mailers\PhpMailer;

/**
 * Class Template
 *
 * @property int $Id
 * @property string $Filter
 * @property string $Title
 * @property string $Subject
 * @property string $From
 * @property string $FromName
 * @property bool $SendPassbook
 * @property bool $SendUnsubscribe
 * @property bool $SendUnverified
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
 * @property int $RelatedEventId
 * @property Event $RelatedEvent
 * @property string $MailerClass
 *
 * @method Template findByPk(int $pk)
 */
class Template extends ActiveRecord
{
    const UsersPerSend = 200;

    const MAILER_PHP = 'PhpMailer';
    const MAILER_MANDRILL = 'TrueMandrillMailer';
    const MAILER_AMAZON_SES = 'SESMailer';

    private $testMode  = false;
    private $testUsers = [];
    public $Attachments = [];

    private $viewPath;


    /**
     * @param string $className
     *
     * @return Template
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string
     */
    public function tableName()
    {
        return 'MailTemplate';
    }

    /**
     * @return int
     */
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

    /**
     * @throws \Exception
     */
    public function send()
    {
        if (!$this->Success){
            if (!$this->getIsTestMode()){
                $mails = [];
                foreach ($this->getUsers() as $user){
                    $mails[] = new \mail\components\mail\Template($this->getMailer(), $user, $this);
                }
                if (!empty($mails)){
                    $this->getMailer()->send($mails);
                }
            } else{
                foreach ($this->testUsers as $user){
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
     * Rollbacks the mail
     *
     * @return bool
     */
    public function rollback()
    {
        if (!$this->Success) {
            return false;
        }

        $this->Success = false;
        $this->SuccessTime = null;
        $this->Active = false;
        $this->LastUserId = null;
        return $this->save(false);
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
     * @property bool $all
     * @return \CDbCriteria
     */
    public function getCriteria($all = false)
    {
        $criteria = new \CDbCriteria();
        $criteria->with = ['Settings'];
        $criteria->order = '"t"."Id" ASC';
        $criteria->addCondition('"t"."Email" != \'\'');

        if (!$this->getIsTestMode()){
            if (!$this->SendUnsubscribe){
                $criteria->addCondition('NOT "Settings"."UnsubscribeAll"');
                if (!empty($this->RelatedEventId)) {
                    $criteria->addCondition('"t"."Id" NOT IN (SELECT "UserId" FROM "UserUnsubscribeEventMail" WHERE "EventId" = :RelativeEventId)');
                    $criteria->params['RelativeEventId'] = $this->RelatedEventId;
                }
            }

            if (!$this->SendUnverified) {
                $criteria->addCondition('"t"."Verified"');
            }


            if (!$this->SendInvisible){
                $criteria->addCondition('"t"."Visible"');
            }
        }

        if (!$this->getIsTestMode() && !$all && $this->LastUserId !== null){
            $criteria->addCondition('"t"."Id" > :LastUserId');
            $criteria->params['LastUserId'] = $this->LastUserId;
        }
        $filter = $this->getFilter();
        if (!empty($filter)){
            $criteria->mergeWith($filter->getCriteria());
        }
        return $criteria;
    }

    /**
     * @return null|string
     */
    public function getViewName()
    {
        if (!$this->getIsNewRecord()){
            return 'mail.views.templates.template'.$this->Id;
        }
        return null;
    }

    /**
     * @return null|string
     */
    public function getViewPath()
    {
        if ($this->viewPath == null && !$this->getIsNewRecord()){
            $this->viewPath = \Yii::getPathOfAlias($this->getViewName()).'.php';
        }
        return $this->viewPath;
    }

    /**
     * Возращает true, если представление рассылки было изменено из вне
     * @return bool
     */
    public function checkViewExternalChanges()
    {
        return md5_file($this->getViewPath()) !== $this->ViewHash;
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

    /**
     * @return bool
     */
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

    /**
     * @return Main
     */
    public function getFilter()
    {
        return unserialize(base64_decode($this->Filter));
    }

    /**
     * @param $filter
     */
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
        if (is_null($this->mailer)) {
            $className = 'mail\\components\\mailers\\' . $this->MailerClass;
            $fileName = \Yii::getPathOfAlias('application.modules') . strtr($className, ['\\' => '/']) . '.php';

            if (!file_exists($fileName)) {
                // use fallback option for mailer class
                \Yii::log("Mailer class $className is not found", \CLogger::LEVEL_ERROR);
                $this->mailer = new PhpMailer();
            } else {
                $this->mailer = new $className();
            }
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
