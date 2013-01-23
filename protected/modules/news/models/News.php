<?php
namespace news\models;
/**
 * @property int Id
 * @property string Title
 * @property string PreviewText
 * @property string Date
 * @property string Url
 * @property string UrlHash
 *  
 */
class News extends \CActiveRecord
{
  public static function model($className=__CLASS__)
  {    
    return parent::model($className);
  }
  
  public function tableName()
  {
    return 'News';
  }

  protected function beforeSave()
  {
    if ($this->getIsNewRecord())
    {
      $this->UrlHash = md5($this->Url);
    }
    return parent::beforeSave();
  }

  public function byUrl($url, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."UrlHash" = :UrlHash';
    $criteria->params = array('UrlHash' => md5($url));
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
}
