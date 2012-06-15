<?php
AutoLoader::Import('library.rocid.user.*');

/**
 * @property int $CommentId
 * @property int $ParentId
 * @property int $ObjectId
 * @property string $ObjectType
 * @property string $Content
 * @property int $UserId
 * @property string $PostDate
 * @property int $Deleted
 *
 * @property User $User
 */
class CommentModel extends CActiveRecord
{
  const ObjectNews = 'news';
  const ObjectEvent = 'event';
  const ObjectLunch = 'lunch';

  public static $ObjectsAll = array(self::ObjectNews, self::ObjectEvent, self::ObjectLunch);

  public static $TableName = 'Mod_Comments';
  
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
    return 'CommentId';
  }
  
  public function relations()
  {
    return array(
      'User' => array(self::BELONGS_TO, 'User', 'UserId')
    );
  }

  /**
   * @static
   * @param int $commentId
   * @return CommentModel
   */
  public static function GetById($commentId)
  {
    $comment = CommentModel::model();
    return $comment->findByPk($commentId);
  }

  /**
   * @static
   * @param int $objectId
   * @param string $objectType
   * @return CommentModel[]
   */
  public static function GetByObjectId($objectId, $objectType)
  {
    $comment = CommentModel::model()->with('User');
    $criteria = new CDbCriteria();
    $criteria->condition = 't.ObjectId = :ObjectId AND t.ObjectType = :ObjectType AND t.Deleted = 0';
    $criteria->params = array(':ObjectId' => $objectId, ':ObjectType' => $objectType);
    $criteria->order = 't.PostDate';
    return $comment->findAll($criteria);
  }

  public static $GetByPageCountLast = 0;
  /**
   * @static
   * @param $count
   * @param int $page
   * @return CommentModel[]
   */
  public static function GetByPage($count, $page = 1)
  {
    $comment = CommentModel::model();
    self::$GetByPageCountLast = $comment->count();

    $comment = CommentModel::model()->with('User');
    $criteria = new CDbCriteria();
    $criteria->limit = $count;
    $criteria->offset = $count * ($page - 1);
    $criteria->order = 't.PostDate DESC';
    return $comment->findAll($criteria);
  }



  /**
   * @param string $content
   * @return void
   */
  public function SetContent($content)
  {
    $purifier = new CHtmlPurifier();
    $purifier->options = array('HTML.AllowedElements' => array('p', 'br', 'strong', 'em'),
                                 'HTML.AllowedAttributes' => '', 'AutoFormat.AutoParagraph' => true);
    $this->Content = $purifier->purify($content);
  }

}