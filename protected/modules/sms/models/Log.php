<?php
namespace sms\models;

use application\components\db\MongoLogDocument;

/**
 * Class Log
 * @package sms\models
 *
 * @property int $Id
 * @property string $To
 * @property string $Message
 * @property string $Error
 */
class Log extends MongoLogDocument
{
    /**
     * @param string $className
     * @return Log
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function collectionName()
    {
        return 'SmsLog';
    }
} 