<?php
namespace api\models;

use application\components\db\MongoLogDocument;

/**
 * @property int $Id
 * @property int $AccountId
 * @property string $Route
 * @property string $Params
 * @property float $DbTime
 * @property float $FullTime
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

    /**
     * @inheritDoc
     */
    public function collectionName()
    {
        return 'ApiLog';
    }
}