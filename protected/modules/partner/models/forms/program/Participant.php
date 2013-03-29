<?php
namespace partner\models\forms\program;

class Participant extends \CFormModel
{
  public $Id;
  public $RunetId;
  public $RoleId;
  public $ReportTitle;
  public $ReportThesis;
  public $ReportUrl;
  public $Delete;
  public $Order;


  public function rules()
  {
    return array(
      array('Id, Order', 'numerical', 'allowEmpty' => true),
      array('RoleId, RunetId', 'required'),
      array('ReportTitle, ReportThesis, Delete', 'safe'),
      array('ReportUrl', 'url', 'allowEmpty' => true)
    );
  }
  
  public function attributeLabels()
  {
    return array(
      'RunetId' => \Yii::t('app', 'RUNET&ndash;ID'),
      'RoleId' => \Yii::t('app', 'ID роли'),
      'ReportTitle' => \Yii::t('app', 'Заголовок доклада'),
      'ReportThesis' => \Yii::t('app', 'Тезисы доклада'),
      'ReportUrl' => \Yii::t('app', 'Url доклада'),
      'Delete' => \Yii::t('app', 'Удалить'),
      'Order' => \Yii::t('app', 'Сортировка'),
      'Role' => \Yii::t('app', 'Роль'),
      'Report' => \Yii::t('app', 'Доклад')
    );
  }
}
