<?php
namespace partner\models\forms\user;


class ParticipantSearch extends \CFormModel
{
  private $event;
  
  public $User;
  public $Role;
  public $Sort;
  public $Ruvents;

  public function __construct(\event\models\Event $event, $scenario = '')
  {
    parent::__construct($scenario);
    $this->event = $event;
  }
  
  public function rules()
  {
    return array(
      array('User, Role, Sort, Ruvents', 'safe')
    );
  }

  /**
   * @return \CDbCriteria
   */
  public function getCriteria()
  {
    $criteria = new \CDbCriteria();

    $criteria->addCondition('"Participants"."EventId" = :EventId');
    $criteria->params['EventId'] = $this->event->Id;
    $criteria->with = [
      'Participants' => [
        'together' => true,
        'select' => false,
      ],
      'Badges' =>  [
        'alias' => 'BadgesForCondition',
        'select' => false,
        'together' => true,
        'on' => '"BadgesForCondition"."EventId" = :EventId'
      ]
    ];
    $criteria->group = '"t"."Id"';    
    
    if ($this->User != '')
    {
      $this->User = trim($this->User);
      if (filter_var($this->User, FILTER_VALIDATE_EMAIL) !== false)
      {
        $criteria->addCondition('"t"."Email" = :Email');
        $criteria->params['Email'] = $this->User;
      }
      else
      {
        $criteria->mergeWith(\user\models\User::model()->bySearch($this->User, null, true, false)->getDbCriteria());
      }
    }

    if ($this->Role != '')
    {
      $criteria->addCondition('"Participants"."RoleId" = :RoleId');
      $criteria->params['RoleId'] = (int)$this->Role;
    }
    
    if (!empty($this->Ruvents))
    {
      $criteria->addCondition('"BadgesForCondition"."EventId" = :EventId');
    }

    $criteria->mergeWith($this->getSortCriteria());

    return $criteria;
  }

  /**
   * @return \CDbCriteria
   */
  protected function getSortCriteria()
  {
    $criteria = new \CDbCriteria();

    $sortValues = $this->getSortValues();
    $this->Sort = trim($this->Sort);
    $this->Sort = isset($sortValues[$this->Sort]) ? $this->Sort : 'DateRegister_DESC';
    $sort = explode('_', $this->Sort);
    switch ($sort[0])
    {
      case 'DateRegister':
        $criteria->order = '"max"("Participants"."CreationTime")';
        break;
      case 'LastName':
        $criteria->order = '"t"."LastName"';
        break;
      case 'Ruvents':
        $criteria->order = 'Min("BadgesForCondition"."CreationTime")';
        break;
    }
    $criteria->order .= ' ' . $sort[1];

    return $criteria;
  }

  public function attributeLabels()
  {
    return array(
      'User' => 'Поисковая строка',
      'Role' => 'Статус',
      'Sort' => 'Сортировка',
      'Ruvents' => 'Прошли регистрацию'
    );
  }

  public function getSortValues()
  {
    $values = [
      'DateRegister_DESC' => 'по дате регистрации &DownArrow;',
      'DateRegister_ASC' => 'по дате регистрации &UpArrow;',
      'LastName_DESC' => 'по ФИО участника &DownArrow;',
      'LastName_ASC' => 'по ФИО участника &UpArrow;'
    ];
    if (!empty($this->Ruvents))
    {
      $values['Ruvents_DESC'] = 'по дате прохода регистрации &DownArrow;';
      $values['Ruvents_ASC']  = 'по дате прохода регистрации &UpArrow;';
    }
    return $values;
  }
}