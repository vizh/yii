<?php


/**
 * @property int $TrendId
 * @property string $Title
 * @property string $Name
 * @property string $Description
 *
 * @property User[] $Experts
 */
class Trend extends CActiveRecord
{
  public static $TableName = 'Mod_ResearchTrend';

  /**
   * @param string $className
   * @return Trend
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return self::$TableName;
  }

  public function primaryKey()
  {
    return 'TrendId';
  }

  public function relations()
  {
    return array(
      'Experts' => array(self::MANY_MANY, 'User', 'Mod_ResearchLinkUserTrend(TrendId, UserId)')
    );
  }

  /**
   * @param User $user
   * @return Trend
   */
  public function byUser($user)
  {
    $criteria = new CDbCriteria();
    $criteria->condition = 'Experts.UserId = :UserId';
    $criteria->params = array(':UserId' => $user->UserId);
    $criteria->with = array('Experts' => array('together' => true, 'select' => false));
    $this->getDbCriteria()->mergeWith($criteria);
    return $this;
  }

  /**
   * @param bool $asc
   * @return Trend
   */
  public function orderOrder($asc = true)
  {
    $criteria = new CDbCriteria();
    $criteria->order = 't.Order' . ($asc ? '' : ' DESC');
    $this->getDbCriteria()->mergeWith($criteria);
    return $this;
  }

  /**
   * @param User $user
   */
  public function AddUser($user)
  {
    Registry::GetDb()->createCommand()->insert('Mod_ResearchLinkUserTrend', array('UserId' => $user->UserId, 'TrendId' => $this->TrendId));
  }

  /**
   * @param User $user
   */
  public function RemoveTrends($user)
  {
    Registry::GetDb()->createCommand()->delete('Mod_ResearchLinkUserTrend', 'UserId = :UserId', array(':UserId' => $user->UserId));
  }



}