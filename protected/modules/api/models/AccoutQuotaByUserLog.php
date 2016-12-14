<?php
namespace api\models;

use application\components\ActiveRecord;

/**
 * @property int $AccountId
 * @property int $UserId
 */
class AccoutQuotaByUserLog extends ActiveRecord
{
    /**
     * @inheritDoc
     */
    public function tableName()
    {
        return 'ApiAccountQuotaByUserLog';
    }
}