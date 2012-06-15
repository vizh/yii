<?php
AutoLoader::Import('library.rocid.tag.*');

class Tag extends CActiveRecord
{
  public static $TableName = 'Core_Tag';
  
  /**
  * @param string $className
  * @return User
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
    return 'TagId';
  }
  
  public function relations()
  {
    return array(
      'TagMap' => array(self::HAS_MANY, 'TagMap', 'TagId'),
    );
  }
  
  /**
  * Добавляет контент в таблицу тегов
  * 
  * @param array[string] $tagNames
  * @param ITagable $content
  */
  public static function AddTaggedContent($tagNames, $content)
  {
    $ids = self::getTagIds($tagNames);
    foreach ($ids as $id)
    {
      try
      {
        $record = new TagMap();
        $record->SetTagId($id);
        $record->SetContentId($content->GetContentId());
        $record->SetContentType($content->GetContentType());
        $record->save();
      }
      catch (Exception $e)
      {
        Lib::log('Возможно попытка записать дублирующий контент на тег');
        Lib::log('Message: ' . $e->getMessage() . ' Trace string: ' . 
          $e->getTraceAsString(), CLogger::LEVEL_ERROR, 'application');
      }
    }
  }
  
  /**
  * Выбирает Id контента типа $contentType которому соответствует $tagName
  * 
  * @param string $tagName
  * @param string $contentType
  * 
  * @return array[int] Массив из id выбранного контента
  */
  public static function GetTaggedContentIds($tagName, $contentType)
  {    
    $tag = Tag::model()->with(array('TagMap' => 
      array('condition' => 'TagMap.ContentType = :ContentType',
      'params' => array(':ContentType' => $contentType))));
    $tag = $tag->find('t.Name = :Name', array(':Name' => $tagName));
    $ids = array();
    foreach ($tag->GetTagMap() as $contentInfo)
    {
      $ids[] = $contentInfo->GetContentId();
    }
    return $ids;
  }
  
  /**
  * Возвращает массив id добавляемых тегов
  * 
  * @param array[string] $tagNames
  * @return array[int]
  */
  private static function getTagIds($tagNames)  
  {
    $criteria = new CDbCriteria();
    $data = Lib::TransformDataArray($tagNames);
    $criteria->condition = 'Name IN (' . implode(',', $data[0]) . ')';
    $criteria->params = $data[1];
    $tags = Tag::model()->findAll($criteria);
    if (sizeof($tags) < sizeof($tagNames))
    {
      $existNames = array();
      foreach ($tags as $tag)
      {
        $existNames[] = $tag->GetName();
      }
      $diff = array_diff($tagNames, $existNames);
      foreach ($diff as $name)
      {
        $tag = new Tag();
        $tag->SetName($name);
        $tag->save();
        $tags[] = $tag;
      }
    }
    $ids = array();
    foreach ($tags as $tag)
    {
      $ids[] = $tag->GetTagId();
    }
    return $ids;
  }
  
  /**
  * Геттеры и сеттеры для полей
  */
  public function GetTagId()
  {
    return $this->TagId;
  }
  
  //Name
  public function GetName()
  {
    return $this->Name;
  }
  
  public function SetName($value)
  {
    $this->Name = $value;
  }
  
  /**
  * 
  * @return array[TagMap]
  */
  public function GetTagMap()
  {
    return $this->TagMap;    
  }
}