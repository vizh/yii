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
  
  public function attributeLabels()
  {
    return array(
      'RunetId' => \Yii::t('app', 'RUNET&mdash;ID'),
      'RoleId' => \Yii::t('app','Роль'),
      'JoinDate' => \Yii::t('app','Дата присоединения'),
      'ExitDate' => \Yii::t('app','Дата выхода')
    );
  }
}
