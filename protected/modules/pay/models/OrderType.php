<?php
namespace pay\models;

final class OrderType
{
  const PaySystem = 1;
  const Juridical = 2;
  const Receipt = 3;
  const MailRu = 4;

  public static function getTitle($type)
  {
    $title = '';
    switch ($type) {
      case self::Juridical:
        $title = 'Счет';
        break;
      case self::Receipt:
        $title = 'Квитанция';
        break;
      case self::MailRu:
        $title = 'Счет Деньги Mail.Ru';
        break;
    }
    return \Yii::t('app', $title);
  }

  public static function getTitleViewOrder($type)
  {
    $title = 'Просмотреть ';
    switch ($type) {
      case self::Juridical:
        $title .= 'счет';
        break;
      case self::Receipt:
        $title .= 'квитанцию';
        break;
      case self::MailRu:
        $title .= 'счет в системе Деньги Mail.Ru';
        break;
    }
    return \Yii::t('app', $title);
  }

  public static function getLong()
  {
    return [self::Juridical, self::Receipt, self::MailRu];
  }

  public static function getIsLong($type)
  {
    $type = intval($type);
    return in_array($type, self::getLong());
  }

  public static function getTemplate()
  {
    return [self::Juridical, self::Receipt];
  }

  public static function getIsTemplate($type)
  {
    $type = intval($type);
    return in_array($type, self::getTemplate());
  }

  public static function getBank()
  {
    return [self::Juridical, self::Receipt];
  }

  public static function getIsBank($type)
  {
    $type = intval($type);
    return in_array($type, self::getBank());
  }


} 