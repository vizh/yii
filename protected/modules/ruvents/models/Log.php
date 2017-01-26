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
     * @param null|string $className
     * @return static
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function collectionName()
    {
        return 'RuventsLog';
    }
}