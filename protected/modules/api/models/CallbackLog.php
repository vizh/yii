<?php
namespace api\models;

/**
 * Class ApiCallback
 * @package api\models
 *
 * @property int $Id
 * @property int $AccountId
 * @property string $Url
 * @property string $Params
 * @property string $Response
 * @property int $ErrorCode
 * @property string $ErrorMessage
 * @property string $CreationTime
 */
class CallbackLog extends \CActiveRecord
{
  /**
   * @param string $className
   *
   * @return CallbackLog
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'ApiCallbackLog';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return [];
  }
}