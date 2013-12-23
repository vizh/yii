<?php
namespace event\models;

/**
* @property int $Id
* @property int $EventId
* @property int $Order
* @property int $ClassId
*
* @property WidgetClass $Class
* @property Event $Event
*/
class LinkWidget extends \CActiveRecord implements \event\components\IWidget
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
    return 'EventLinkWidget';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return array(
      'Event' => [self::BELONGS_TO, '\event\models\Event', 'EventId'],
      'Class' => [self::BELONGS_TO, '\event\models\WidgetClass', 'ClassId']
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
      if ($this->Class == null)
      {
        throw new \application\components\Exception('Не существует виджета мероприятия с Id:' . $this->ClassId);
      }
      
      $this->widget = \Yii::app()->getController()->createWidget($this->Class->Class, array('event' => $this->Event));
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
  
  public function getEvent()
  {
    return $this->Event;
  }
  
  public function getAdminPanel()
  {
    return null;
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
   * @param int $classId
   * @param bool $useAnd
   * @return $this
   */
  public function byClassId($classId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."ClassId" = :ClassId';
    $criteria->params = array('ClassId' => $classId);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param int $eventId
   * @param bool $useAnd
   * @return $this
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