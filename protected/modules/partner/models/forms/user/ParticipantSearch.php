<?php
namespace partner\models\forms\user;


class ParticipantSearch extends \CFormModel
{
  public $User;
  public $Role;
  public $Sort;

  public function rules()
  {
    return array(
      array('User, Role, Sort', 'safe')
    );
  }

  /**
   * @return \CDbCriteria
   */
  public function getCriteria()
  {
    $criteria = new \CDbCriteria();

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
    );
  }

  public function getSortValues()
  {
    return array(
      'DateRegister_DESC' => 'по дате регистрации &DownArrow;',
      'DateRegister_ASC' => 'по дате регистрации &UpArrow;',
      'LastName_DESC' => 'по ФИО участника &DownArrow;',
      'LastName_ASC' => 'по ФИО участника &UpArrow;',
    );
  }
}