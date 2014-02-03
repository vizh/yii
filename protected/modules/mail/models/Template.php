<?php
namespace mail\models;

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
 * @property string $Layout
 *
 */
class Template extends \CActiveRecord
{
  const UsersPerSend = 100;

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

  public function send()
  {
    $mailer = new \mail\components\mailers\PhpMailer();
    if (!$this->Success)
    {
      $recipients = [];
      if (!$this->getIsTestMode())
      {
        $recipients = $this->getUsers();
      }
      else
      {
        $criteria = new \CDbCriteria();
        $criteria->addInCondition('"t"."Id"', \CHtml::listData($this->testUsers, 'Id', 'Id'));
        $criteria->mergeWith($this->getCriteria());
        $recipients = \user\models\User::model()->findAll($criteria);
      }
      foreach ($recipients as $user)
      {
        $mail = new \mail\components\mail\Template($mailer, $this, $user);
        $mail->send();
      }
    }
  }

  /**
   * @return \user\models\User[]
   */
  public function getUsers()
  {
    $criteria = $this->getCriteria();
    $criteria->limit = self::UsersPerSend;
    $users = \user\models\User::model()->findAll($criteria);
    if (empty($users))
    {
      $this->Success = true;
      $this->SuccessTime = date('Y-m-d H:i:s');
    }
    else
    {
      $this->LastUserId = $users[sizeof($users)-1]->Id;
    }
    $this->save();
    return $users;
  }

  /**
   * @return \CDbCriteria
   */
  public function getCriteria($all = false)
  {
    $criteria = new \CDbCriteria();
    $criteria->with = ['Settings'];
    $criteria->order = '"t"."Id" ASC';

    if (!$this->getIsTestMode())
    {
      if (!$this->SendUnsubscribe)
      {
        $criteria->addCondition('NOT "Settings"."UnsubscribeAll"');
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
   * @param \user\models\User $users[]
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
}