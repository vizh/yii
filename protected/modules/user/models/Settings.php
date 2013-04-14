<?php
namespace user\models;

/**
 * @property int $Id
 * @property int $UserId
 * @property int $Verify
 * @property int $Agreement
 * @property int $IndexProfile
 * @property string $WhoView
 * @property int $ProjNews Новости системы rocID
 * @property int $EventNews Еженедельный дайджест событий на rocID
 * @property int $NoticePhoto Уведомлять о фотографиях и видео, на которых вас отметили
 * @property int $NoticeMsg
 * @property int $NoticeProfile
 * @property int $HideFatherName
 * @property int $HideBirthdayYear
 *
 */
class Settings extends \CActiveRecord
{
  public static function model($className=__CLASS__)
  {    
    return parent::model($className);
  }
  
  public function tableName()
  {
    return 'UserSettings';
  }
  
  public function primaryKey()
  {
    return 'Id';
  }
  
  public function relations()
  {
    return array(
      'User' => array(self::BELONGS_TO, 'User', 'UserId'),        
    );
  }
}
