<?php
AutoLoader::Import('library.rocid.user.User');
AutoLoader::Import('library.rocid.tag.*');

class News extends CActiveRecord implements ITagable
{
  public static $TableName = 'Mod_NewsPost';
  
 /**
  * @param string $className
  * @return News
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
    return 'PhotoId';
  }
  
  public function relations()
  {
    return array(   
      'Comments' => array(self::HAS_MANY, 'NewsComment', 'NewsId'),
      'User' => array(self::BELONGS_TO, 'User', 'UserId')
    );
  }
  
  /**
  * Возвращает все новости, появившиеся не раньше $limitDate и относящиеся
  * к событиям $events. Если массив $events пустой - берутся новости не относящиеся к каким либо мероприятиям.
  * Если массив null - берутся все новости
  * 
  * @param int $limitDate
  * @param array[int] $events Массив с Id мероприятий, пустой массив - если общие новости, null - если все новости
  * @return array[News]
  */
  public static function GetLastNewsByDate($limitDate, $events = array())
  {    
    $criteria = new CDbCriteria();
    $criteria->condition = 'CreationTime > :TimeNow';
    $paramEventId = '';
    if ($events !== null)
    {
      $criteria->condition .= ' AND ';
      if (empty($events))
      {
        $criteria->condition .= 'EventId = :EventId';
        $paramEventId = 0;
      }
      else
      {
        $criteria->condition .= 'EventId IN :EventId';
        $paramEventId = '(' . implode(',', $events) . ')';
      }
    }     
    $criteria->order = 'CreationTime';
    $criteria->params = array(':TimeNow' => $limitDate, ':EventId' => $paramEventId);
    
    $news = News::model()->findAll($criteria);
    return $news;
  }

  
/**
* ITagable Members
*/
  public function GetContentType()
  {
    return 'News';
  }
  
  public function GetContentId()
  {
    return $this->GetNewsId();
  }
}