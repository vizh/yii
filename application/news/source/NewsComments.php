<?php
AutoLoader::Import('library.rocid.user.*');

/**
 * @property int $CommentId
 * @property int $ParentId
 * @property int $NewsPostId
 * @property string $Content
 * @property int $UserId
 * @property string $PostDate
 *
 * @property User $User
 */
class NewsComments extends CActiveRecord
{
  public static $TableName = 'Mod_NewsComment';
  
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
      'NewsPost' => array(self::BELONGS_TO, 'NewsPost', 'NewsPostId'),
      'User' => array(self::BELONGS_TO, 'User', 'UserId')
    );
  }

  /**
   * @static
   * @param int $commentId
   * @return NewsComments
   */
  public static function GetById($commentId)
  {
    $comment = NewsComments::model();
    return $comment->findByPk($commentId);
  }

  /**
   * @static
   * @param int $newsPostId
   * @return NewsComments[]
   */
  public static function GetByNewsId($newsPostId)
  {
    $comment = NewsComments::model()->with('User');
    $criteria = new CDbCriteria();
    $criteria->condition = 't.NewsPostId = :NewsPostId';
    $criteria->params = array(':NewsPostId' => $newsPostId);
    $criteria->order = 't.PostDate';
    return $comment->findAll($criteria);
  }



  /**
   * @param string $content
   * @return void
   */
  public function SetContent($content)
  {
    $content = strip_tags($content);
    $this->Content = $content;
  }


}
