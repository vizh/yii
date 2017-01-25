<?php
namespace oauth\models;

use application\components\ActiveRecord;
use user\models\User;

/**
 * @property int $Id
 * @property int $UserId
 * @property int $SocialId
 * @property string $Hash
 *
 * @property User $User
 *
 * Описание вспомогательных методов
 * @method Social   with($condition = '')
 * @method Social   find($condition = '', $params = [])
 * @method Social   findByPk($pk, $condition = '', $params = [])
 * @method Social   findByAttributes($attributes, $condition = '', $params = [])
 * @method Social[] findAll($condition = '', $params = [])
 * @method Social[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Social byId(int $id, bool $useAnd = true)
 * @method Social byUserId(int $id, bool $useAnd = true)
 * @method Social bySocialId(int $id, bool $useAnd = true)
 * @method Social byHash(string $hash, bool $useAnd = true)
 */
class Social extends ActiveRecord
{
    /**
     * @param string $className
     * @return Social
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'OAuthSocial';
    }

    public function relations()
    {
        return [
            'User' => [self::BELONGS_TO, '\user\models\User', 'UserId'],
            'Social' => [self::BELONGS_TO, '\contact\models\ServiceType', 'SocialId'],
        ];
    }
}