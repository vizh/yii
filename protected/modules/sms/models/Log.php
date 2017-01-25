<?php
namespace sms\models;

use application\components\db\MongoLogDocument;

/**
 * @property int $Id
 * @property string $To
 * @property string $Message
 * @property string $Error
 */
class Log extends MongoLogDocument
{
    /**
     * @param string $className
     * @return static
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function collectionName()
    {
        return 'SmsLog';
    }
}