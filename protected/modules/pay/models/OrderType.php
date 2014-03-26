<?php
namespace pay\models;

final class OrderType
{
  const PaySystem = 1;
  const Juridical = 2;
  const Receipt = 3;
  const MailRu = 4;

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