<?php
AutoLoader::Import('library.rocid.user.User');
AutoLoader::Import('library.rocid.settings.*');

/**
 * @property int $SettingId
 * @property int $UserId
 * @property int $Verify
 * @property int $Agreement
 * @property int $Visible
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
class UserSettings extends CActiveRecord
{
  private static function getCacheTime()
  {
    return 60 * 60;
  }

  /**
  * Возвращает ключ для кеша или null, если пользователь не найден
  * @return string|null
  */
  private function getCacheKey()
  {
    if ($user = $this->GetUser())
    {
      return SettingManager::GetCacheKey() . '_' . $this->GetUser()->GetUserId();
    }
    else
    {
      return null;
    }
  }

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
    return 'SettingId';
  }
  
  public function relations()
  {
    return array(
      'User' => array(self::BELONGS_TO, 'User', 'UserId'),        
    );
  }

  /**
  * Получает массив опций вида $name => $value, обновляет настройки в БД и обнуляет кеш
  *
  * @param array $settings
  */
  public function SetGeneralSettings($settings)
  {
    $cacheSettings = $this->getCacheSettings();
    foreach ($settings as $key => $value)
    {
      $cacheSettings[$key] = $value;
    }
    $cache = Registry::GetCache();
    if ($cache !== null)
    {
      $cache->Delete($this->getCacheKey());
    }
    $this->GeneralSettings = serialize($cacheSettings);
    $this->save();
  }

  /**
  * Возвращает пользовательское значение настройки $name или null - если такой настройки у
  * пользователя нет
  *
  * @param string $name
  * @return string|null
  */
  public function GetGeneralSetting($name)
  {
    $cacheSettings = $this->getCacheSettings();
    return isset($cacheSettings[$name]) ? $cacheSettings[$name] : null;
  }

  /**
  * Загружает настройки из кеша или из БД, если настройки не были кешированы ранее
  *
  * @return array[string]
  */
  private function getCacheSettings()
  {
    $cache = Registry::GetCache();
    if ($cache !== null && $settings = $cache->Get($this->getCacheKey()))
    {
      return $settings;
    }
    else
    {
      if (isset($this->GeneralSettings))
      {
        $settings = unserialize($this->GeneralSettings);
        if ($cache !== null)
        {
          $cache->Set(self::getCacheKey(), $settings, self::getCacheTime());
        }
        return $settings;
      }
      else
      {
        return array();
      }
    }
  }

  /**
  * @return User
  */
  public function GetUser()
  {
    $user = $this->User;
    if (isset($user))
    {
      return $user;
    }
    else
    {
      return null;
    }
  }

  public function ApplyAgree()
  {
    $this->Agreement = 1;
    $this->ProjNews = 1;
    $this->EventNews = 1;
    $this->NoticePhoto = 1;
    $this->NoticeMsg = 1;
    $this->NoticeProfile = 1;
    $this->save();
  }
}
