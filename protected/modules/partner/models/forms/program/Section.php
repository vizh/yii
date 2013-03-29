<?php
namespace partner\models\forms\program;
class Section extends \CFormModel
{
  public $Title;
  public $Info;
  public $Date;
  public $TimeStart;
  public $TimeEnd;
  public $Hall;
  public $HallNew;
  public $Attribute;
  public $AttributeNew;
  public $Type;
  
  
  public function attributeLabels()
  {
    return array(
      'Title' => \Yii::t('app', 'Название секции'),
      'Info' => \Yii::t('app', 'Описание'),
      'Date' => \Yii::t('app', 'Дата'),
      'Hall' => \Yii::t('app', 'Зал'),
      'AttributeNew' => \Yii::t('app', 'Новый атрибут'),
      'TimeStart' => \Yii::t('app', 'Время начала'),
      'TimeEnd' => \Yii::t('app', 'Время окончания'),
      'Type' => \Yii::t('app', 'Тип')
    );
  }
  
  public function rules()
  {
    return array(
      array('Title, Date, TimeStart, TimeEnd, Type', 'required'),
      array('Date', 'date', 'format' => 'yyyy-MM-dd'),
      array('TimeStart, TimeEnd', 'date', 'format' => 'HH:mm'),
      array('Hall, HallNew, Attribute, AttributeNew, Info', 'safe')
    );
  }
  
  /**
   * 
   * @param \event\models\Event $event
   * @return string[]
   */
  public function getDateList($event)
  {
    $list = array();
    $dt = new \DateTime();
    $dt->setTimestamp($event->getTimeStampStartDate());
    while ($dt->getTimestamp() <= $event->getTimeStampEndDate())
    {
      $list[$dt->format('Y-m-d')] = $dt->format('d.m.Y');
      $dt->modify('+1 day');
    }
    return $list;
  }
  
  /**
   * 
   * @param \event\models\Event $event
   * return string[]
   */
  public function getAttributeList($event, $section)
  {
    $list = array();
    $criteria = new \CDbCriteria();
    $criteria->with = array(
      'Section'
    );
    $criteria->condition = '"Section"."EventId" = :EventId';
    $criteria->params['EventId'] = $event->Id;
    $attributes = \event\models\section\Attribute::model()->findAll($criteria);
    foreach ($attributes as $attribute)
    {
      $list[$attribute->Name] = '';
    }
    
    if (!empty($section->Attributes))
    {
      foreach ($section->Attributes as $attribute);
      {
        $list[$attribute->Name] = $attribute->Value;
      }
    }
    return $list;
  }
  
  /**
   * 
   */
  public function getTypeList()
  {
    $list = array();
    $types = \event\models\section\Type::model()->findAll();
    foreach ($types as $type)
    {
      $list[$type->Id] = $type->Title;
    }
    return $list;
  }
}
