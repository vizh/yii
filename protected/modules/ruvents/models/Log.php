<?php
namespace ruvents\models;

use application\components\db\MongoLogDocument;

/**
 * @property int $Id
 * @property int $EventId
 * @property int $OperatorId
 * @property string $Route
 * @property string $Params
 * @property string $FullTime
 * @property int $ErrorCode
 * @property string $ErrorMessage
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
        return 'RuventsLog';
    }
}