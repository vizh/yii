<?php
namespace event\models;

use application\components\ActiveRecord;
use contact\models\Site;

/**
 * @property int $Id
 * @property int $EventId
 * @property int $SiteId
 *
 * @property Event $Event
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
 * @method LinkSite byEventId(int $id, bool $useAnd = true)
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
        return 'EventLinkSite';
    }

    public function relations()
    {
        return [
            'Event' => [self::BELONGS_TO, '\event\models\Event', 'EventId'],
            'Site' => [self::BELONGS_TO, '\contact\models\Site', 'SiteId'],
        ];
    }
}
