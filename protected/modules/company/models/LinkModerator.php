<?php
namespace company\models;

use application\components\ActiveRecord;
use user\models\User;

/**
 * @property int $Id
 * @property int $UserId
 * @property int $CompanyId
 *
 * @property User $User
 *
 * Описание вспомогательных методов
 * @method LinkModerator   with($condition = '')
 * @method LinkModerator   find($condition = '', $params = [])
 * @method LinkModerator   findByPk($pk, $condition = '', $params = [])
 * @method LinkModerator   findByAttributes($attributes, $condition = '', $params = [])
 * @method LinkModerator[] findAll($condition = '', $params = [])
 * @method LinkModerator[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method LinkModerator byId(int $id, bool $useAnd = true)
 * @method LinkModerator byUserId(int $id, bool $useAnd = true)
 * @method LinkModerator byCompanyId(int $id, bool $useAnd = true)
 */
class LinkModerator extends ActiveRecord
{
    /**
     * @param string $className
     * @return LinkModerator
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'CompanyLinkModerator';
    }

    public function relations()
    {
        return [
            'User' => [self::BELONGS_TO, '\User\models\User', 'UserId']
        ];
    }
}
