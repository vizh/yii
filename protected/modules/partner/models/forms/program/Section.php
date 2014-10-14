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
      ['Title, Date, TimeStart, TimeEnd, Type', 'required'],
      ['Date', 'date', 'format' => 'yyyy-MM-dd'],
      ['TimeStart, TimeEnd', 'date', 'format' => 'HH:mm'],
      ['Hall, HallNew, Attribute, Info', 'safe'],
      ['AttributeNew', 'filter', 'filter' => [$this, 'filterAttributeNew']]
    );
  }
  
  public function filterAttributeNew($value)
  {
    if (!empty($value['Name']) && !preg_match('/^\w[\w\d_]*$/i', $value['Name']))
    {
      $this->addError('AttributeNew', \Yii::t('app', 'Неверное имя атрибута. Разрешается использование только латинских букв, цифр и "_".'));
    }
    return $value;
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
    $attributes = \Yii::app()->db->createCommand()
      ->from(\event\models\section\Attribute::model()->tableName().' Attribute')
      ->selectDistinct('Attribute.Name')
      ->join(\event\models\section\Section::model()->tableName()." as Section", '"Section"."Id" = "Attribute"."SectionId"')
      ->where('"Section"."EventId" = :EventId AND NOT "Section"."Deleted"', array('EventId' => $event->Id))
      ->queryColumn();
    
    $list = array_fill_keys($attributes,'');
    foreach ($section->Attributes as $attribute)
    {
      $list[$attribute->Name] = $attribute->Value;
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
