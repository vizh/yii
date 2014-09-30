<?php
namespace sms\models;

/**
 * Class Log
 * @package sms\models
 *
 * @property int $Id
 * @property string $To
 * @property string $Message
 * @property string $SendTime
 * @property string $Error
 */
class Log extends \CActiveRecord
{
    /**
     * @param string $className
     * @return Log
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'SmsLog';
    }

    public function primaryKey()
    {
        return 'Id';
    }
} 