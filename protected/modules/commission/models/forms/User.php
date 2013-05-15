<?php
namespace commission\models\forms;

class User extends \CFormModel
{
  const DATE_FORMAT = 'dd.MM.yyyy';

  public $Id;
  public $RunetId;
  public $RoleId;
  public $JoinDate;
  public $ExitDate;
  
  public function rules()
  {
    return array(
      array('RunetId, RoleId, JoinDate', 'required'),
      array('Id', 'exist', 'allowEmpty' => true, 'className' => '\commission\models\User', 'attributeName' => 'Id'),
      array('RunetId', 'exist', 'className' => '\user\models\User', 'attributeName' => 'RunetId'),
      array('RoleId', 'exist', 'className' => '\commission\models\Role', 'attributeName' => 'Id'),
      array('JoinDate', 'date', 'format' => self::DATE_FORMAT),
      array('ExitDate', 'date', 'allowEmpty' => true, 'format' => self::DATE_FORMAT),
    );
  }

  public function attributeLabels()
  {
    return array(
      'RunetId' => \Yii::t('app', 'RUNET&mdash;ID'),
      'RoleId' => \Yii::t('app','Роль'),
      'JoinDate' => \Yii::t('app','Дата присоединения'),
      'ExitDate' => \Yii::t('app','Дата выхода')
    );
  }
  
  public function getRoleList()
  {
    $criteria = new \CDbCriteria();
    $criteria->order = '"t"."Priority" DESC';
    return \CHtml::listData(\commission\models\Role::model()->findAll($criteria), 'Id', 'Title');
  }
}
