<?php
namespace user\models;

use application\components\ActiveRecord;
use contact\models\Site;

/**
 * @property int $Id
 * @property int $UserId
 * @property int $SiteId
 *
 * @property User $User
 * @property Site $Site
 *
 * Описание вспомогательных методов
 * @method LinkSite   with($condition = '')
 * @method LinkSite   find($condition = '', $params = [])
 * @method LinkSite   findByPk($pk, $condition = '', $params = [])
 * @method LinkSite   findByAttributes($attributes, $condition = '', $params = [])
 * @method LinkSite[] findAll($condition = '', $params = [])
 * @method LinkSite[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method LinkSite byId(int $id, bool $useAnd = true)
 * @method LinkSite byUserId(int $id, bool $useAnd = true)
 * @method LinkSite bySiteId(int $id, bool $useAnd = true)
 */
class LinkSite extends ActiveRecord
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

    public function tableName()
    {
        return 'UserLinkSite';
    }

    public function relations()
    {
        return [
            'User' => [self::BELONGS_TO, '\user\models\User', 'UserId'],
            'Site' => [self::BELONGS_TO, '\contact\models\Site', 'SiteId'],
        ];
    }
}