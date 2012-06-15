<?php
AutoLoader::Import('library.rocid.user.*');

class SocialWrapper
{
  const Facebook = 'facebook';
  const Twitter = 'twitter';

  private static $twitter = null;
  private static function Twitter()
  {
    if (empty(self::$twitter))
    {
      self::$twitter = RocidTwitterOAuth::GetContent();
    }
    return self::$twitter;
  }

  private static $facebook = null;
  private static function Facebook()
  {
    if (empty(self::$facebook))
    {
      self::$facebook = RocidFacebook::GetUserInfo();
    }
    return self::$facebook;
  }

  public static function UserId($social)
  {
    switch ($social)
    {
      case self::Facebook:
        $facebook = self::Facebook();
        return !empty($facebook) ? $facebook['id'] : null;
        break;
      case self::Twitter:
        $twitter = self::Twitter();
        return !empty($twitter) ? $twitter->id : null;
        break;
    }
  }

  public static function LastName($social)
  {
    switch ($social)
    {
      case self::Facebook:
        $facebook = self::Facebook();
        return !empty($facebook) ? $facebook['last_name'] : '';
        break;
      case self::Twitter:
        $twitter = self::Twitter();
        $name = !empty($twitter->name) ? $twitter->name : '';
        $parts = preg_split('/ /', $name, -1,PREG_SPLIT_NO_EMPTY);
        return isset($parts[1]) ? $parts[1] : '';
        break;
    }
  }

  public static function FirstName($social)
  {
    switch ($social)
    {
      case self::Facebook:
        $facebook = self::Facebook();
        return !empty($facebook) ? $facebook['first_name'] : '';
        break;
      case self::Twitter:
        $twitter = self::Twitter();
        $name = !empty($twitter->name) ? $twitter->name : '';
        $parts = preg_split('/ /', $name, -1,PREG_SPLIT_NO_EMPTY);
        return isset($parts[0]) ? $parts[0] : '';
        break;
    }
  }

  public static function Email($social)
  {
    switch ($social)
    {
      case self::Facebook:
        $facebook = self::Facebook();
        return !empty($facebook) ? $facebook['email'] : '';
        break;
      case self::Twitter:
        return '';
        break;
    }
  }

  public static function GetUserConnect($social, $socialId)
  {
    switch ($social)
    {
      case self::Facebook:
        $social = UserConnect::FacebookId;
        break;
      case self::Twitter:
        $social = UserConnect::TwitterId;
        break;
    }
    return UserConnect::GetByHash($socialId, $social);
  }

  public static function CreateUserConnect($social, $socialId, $userId)
  {
    $userConnect = new UserConnect();
    switch ($social)
    {
      case self::Facebook:
        $userConnect->ServiceTypeId = UserConnect::FacebookId;
        break;
      case self::Twitter:
        $userConnect->ServiceTypeId = UserConnect::TwitterId;
        break;
    }
    $userConnect->UserId = $userId;
    $userConnect->Hash = $socialId;
    $userConnect->save();
  }

  public static function Identity($social, $socialId)
  {
    $identity = null;
    switch ($social)
    {
      case self::Facebook:
        $identity = new FacebookIdentity($socialId);
        break;
      case self::Twitter:
        $identity = new TwitterIdentity($socialId);
        break;
    }
    return $identity;
  }
}
