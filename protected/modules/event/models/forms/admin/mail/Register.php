<?php
namespace event\models\forms\admin\mail;


class Register extends \CFormModel
{
  public $Subject;
  public $Body;
  public $Roles = [];
  public $RolesExcept = [];
  public $Delete = 0;

  public function rules()
  {
    return [
      ['Subject,Body', 'required'],
      ['Delete', 'safe'],
      ['Body', 'filter', 'filter' => [new \application\components\utility\Texts(), 'filterPurify']],
      ['Roles, RolesExcept', 'filter', 'filter' => [$this, 'filterRoles']]
    ];
  }

  public function attributeLabels()
  {
    return [
      'Subject' => \Yii::t('app', 'Тема письма'),
      'Body' => \Yii::t('app', 'Тело письма'),
      'Roles' => \Yii::t('app', 'Роли'),
      'RolesExcept' => \Yii::t('app', 'Исключая роли')
    ];
  }

  public function getEventRoleData()
  {
    $data = [];
    $roles = \event\models\Role::model()->findAll();
    foreach ($roles as $role)
    {
      $data[] = ['label' => $role->Title, 'value' => $role->Id];
    }
    return $data;
  }

  public function filterRoles($value)
  {
    $valid = true;
    if (is_array($value))
    {
      foreach ($value as $roleId)
      {
        if (!\event\models\Role::model()->exists('"t"."Id" = :Id', ['Id' => $roleId]))
        {
          $valid = false;
          break;
        }
      }
    }
    else
    {
      $valid = false;
    }

    if (!$valid)
    {
      $this->addError('Roles', \Yii::t('app', 'Ошибка в заполнение поля {field}.',['{field}' => $this->getAttributeLabel('Roles')]));
    }
    return $value;
  }
} 