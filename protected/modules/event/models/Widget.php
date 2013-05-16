<?php
namespace event\models;

/**
 * @property int $Id
 * @property int $EventId
 * @property string $Name
 * @property int $Order
 *
 * @property Event $Event
 */
class Widget extends \CActiveRecord implements \event\components\IWidget
{
  /**
   * @param string $className
   * @return Widget
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'EventWidget';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return array(
      'Event' => array(self::BELONGS_TO, '\event\models\Event', 'EventId'),
    );
  }

  private $widget = null;

  /**
   * @return \event\components\Widget
   * @throws \application\components\Exception
   */
  public function getWidget()
  {
    if ($this->widget === null)
    {
      if (!class_exists($this->Name))
      {
        throw new \application\components\Exception('Не существует виджета мероприятия с именем:' . $this->Name);
      }
      
      $this->widget = \Yii::app()->getController()->createWidget($this->Name, array('event' => $this->Event));
    }

    return $this->widget;
  }

  /**
   * @return string
   */
  public function getTitle()
  {
    return $this->getWidget()->getTitle();
  }

  /**
   * @return string
   */
  public function getName()
  {
    return $this->getWidget()->getName();
  }

  /**
   * @return string
   */
  public function getPosition()
  {
    return $this->getWidget()->getPosition();
  }

  public function process()
  {
    $this->getWidget()->process();
  }

  public function run()
  {
    $this->getWidget()->run();
  }

  /**
   * @return bool
   */
  public function getIsActive()
  {
    return $this->getWidget()->getIsActive();
  }

  /**
   * 
   * @param string $name
   * @param bool $useAnd
   * @return \event\models\Widget
   */
  public function byName($name, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."Name" = :Name';
    $criteria->params = array('Name' => $name);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
  
  /**
   * 
   * @param int $name
   * @param bool $useAnd
   * @return \event\models\Widget
   */
  public function byEventId($eventId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."EventId" = :EventId';
    $criteria->params = array('EventId' => $eventId);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
}
