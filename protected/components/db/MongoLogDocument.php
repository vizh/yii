<?php
namespace application\components\db;

/**
 * Class MongoLogDocument
 * @package application\components\db
 *
 * @property string $CreationTime
 */
class MongoLogDocument extends \EMongoDocument
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'EMongoTimestampBehaviour' => [
                'class' => 'EMongoTimestampBehaviour',
                'createAttribute' => 'CreationTime',
                'updateAttribute' => null
            ]
        ];
    }

}