<?php
namespace mail\models\forms\admin;

class Template extends \CFormModel
{
  const ByEvent = 'Event';

  const TypePositive = 'positive';
  const TypeNegative = 'negative';

  public $Title;
  public $Subject;
  public $From = 'users@runet-id.com';
  public $FromName = '—RUNET—ID—';
  public $SendPassbook;
  public $SendUnsubscribe;
  public $Active = 0;
  public $Test;
  public $TestUsers;
  public $Conditions = [];
  public $Body;

  public function attributeLabels()
  {
    return [
      'Title' => \Yii::t('app', 'Название рассылки'),
      'Subject' => \Yii::t('app', 'Тема письма'),
      'From' => \Yii::t('app', 'Отправитель письма'),
      'FromName' => \Yii::t('app', 'Имя отправителя письма'),
      'SendPassbook' => \Yii::t('app', 'Добавлять PassBook'),
      'SendUnsubscribe' => \Yii::t('app', 'Отправлять отписавшимся'),
      'Active' => \Yii::t('app', 'Рассылка по выбранным получателям'),
      'Test' => \Yii::t('app', 'Получатели тестовой рассылки'),
      'Body' => \Yii::t('app', 'Тело письма')
    ];
  }


  public function rules()
  {
    return [
      ['Title, Subject, From, FromName, SendPassbook, SendUnsubscribe, Active', 'required'],
      ['Test, TestUsers, Body', 'safe'],
      ['From', 'email'],
      ['Conditions', 'default', 'value' => []],
      ['Conditions', 'filter', 'filter' => [$this, 'filterConditions']],
      ['Test', 'filter', 'filter' => [$this, 'filterTest']]
    ];
  }

  public function filterTest($value)
  {
    if ($this->Test == 1)
    {
      $this->TestUsers = trim($this->TestUsers, ', ');
      if (empty($this->TestUsers))
      {
        $this->addError('Test', \Yii::t('app', 'Не указаны получатели тестовой рассылки.'));
      }
    }
    return $value;
  }

  /**
   * @param $value string
   * @return string
   */
  public function filterConditions($value)
  {
    $countByEvent = 0;
    foreach ($value as $key => $condition)
    {
      switch($condition['by'])
      {
        case self::ByEvent:
          $value[$key] = $this->filterConditionByEvent($condition);
          $countByEvent++;
          break;
      }
    }

    if ((preg_match('/{Event.Title}|{TicketUrl}|{Role.Title}/', $this->Body) !== 0 || $this->SendPassbook == 1)
        && $countByEvent !== 1)
    {
      $this->addError('Conditions', \Yii::t('app', 'Для данных настроек, фильтр рассылки должен иметь только одно мероприятие!'));
    }
    return $value;
  }

  /**
   * @param $condition string[]
   */
  private function filterConditionByEvent($condition)
  {
    $event = \event\models\Event::model()->findByPk($condition['eventId']);
    if ($event == null)
    {
      $this->addError('Conditions', \Yii::t('app', 'Не найдена мероприятие с ID:{id}', ['{id}' => $condition['eventId']]));
    }
    if (empty($condition['roles']))
      $condition['roles'] = [];

    return $condition;
  }

  public function bodyFields()
  {
    return [
      '{User.FullName}'  => '<?=$user->getFullName();?>',
      '{User.ShortName}' => '<?=$user->getShortName();?>',
      '{User.RunetId}'   => '<?=$user->RunetId;?>',
      '{UnsubscribeUrl}' => '<?=$user->getFastauthUrl(\'/user/setting/subscription/\');?>',
      '{Event.Title}'    => '<?=$user->Participants[0]->Event->Title;?>',
      '{TicketUrl}'      => '<?=$user->Participants[0]->getTicketUrl();?>',
      '{Role.Title}'     => '<?=$user->Participants[0]->Role->Title;?>'
    ];
  }

  public function bodyFieldLabels()
  {
    return [
      '{User.FullName}'  => \Yii::t('app', 'Полное имя пользователя'),
      '{User.ShortName}' => \Yii::t('app', 'Краткое имя пользователя. Имя или имя + отчество'),
      '{User.RunetId}'   => \Yii::t('app', 'RUNET-ID пользователя'),
      '{Event.Title}'    => \Yii::t('app', 'Название меропрития'),
      '{TicketUrl}'      => \Yii::t('app', 'Ссылка на пригласительный'),
      '{Role.Title}'     => \Yii::t('app', 'Роль на меропритие'),
      '{UnsubscribeUrl}' => \Yii::t('app', 'Ссылка на отписаться')
    ];
  }

  public function getConditionData()
  {
    return [
      self::ByEvent => 'По мероприятию'
    ];
  }

  public function getTypeData()
  {
    return [
      self::TypePositive => \Yii::t('app', 'Добавить'),
      self::TypeNegative => \Yii::t('app', 'Исключить')
    ];
  }

  public function getEventRolesData()
  {
    $data = [];
    $roles = \event\models\Role::model()->findAll(['order' => '"t"."Title"']);
    foreach ($roles as $role)
    {
      $data[] = ['label' => $role->Id.' - '.$role->Title, 'value' => $role->Id];
    }
    return $data;
  }
} 