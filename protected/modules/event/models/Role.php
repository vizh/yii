<?php
namespace event\models;

/**
 * @property int $Id
 * @property string $Code
 * @property string $Title
 * @property int $Priority
 * @property string $Color
 *
 * @method \event\models\Role find($condition='',$params=array())
 * @method \event\models\Role findByPk($pk,$condition='',$params=array())
 * @method \event\models\Role[] findAll($condition='',$params=array())
 */
class Role extends \application\models\translation\ActiveRecord
{

  /**
   * @param string $className
   * @return Role
   */
  public static function model($className=__CLASS__)
  {    
    return parent::model($className);
  }
  
  public function tableName()
  {
    return 'EventRole';
  }
  
  public function primaryKey()
  {
    return 'Id';
  }
  
  public function relations()
  {
    return array(
      'Participants' => array(self::HAS_MANY, 'event\models\Participant', 'RoleId')
    );
  }

  /**
   * @param int $eventId
   * @param bool $useAnd
   *
   * @return $this
   */
  public function byEventId($eventId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"Participants"."EventId" = :EventId';
    $criteria->params = ['EventId' => $eventId];
    $criteria->with = ['Participants' => ['together' => true, 'select' => false]];
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param bool $isBase
   * @param bool $useAnd
   * @return $this
   */
  public function byBase($base = true, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = (!$base ? 'NOT ' : '').'"t"."Base"';
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }


  /**
   * @return string[]
   */
  public function getTranslationFields()
  {
    return ['Title'];
  }
}