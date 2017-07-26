<?php
namespace event\models;

use application\models\translation\ActiveRecord;
use JsonSerializable;

/**
 * @property int $Id
 * @property string $Code
 * @property string $Title
 * @property string $CssClass
 * @property int $Priority
 *
 * @property int $EventsCount Количество мероприятий обладающих данным типом.
 *
 * Описание вспомогательных методов
 * @method Type   with($condition = '')
 * @method Type   find($condition = '', $params = [])
 * @method Type   findByPk($pk, $condition = '', $params = [])
 * @method Type   findByAttributes($attributes, $condition = '', $params = [])
 * @method Type[] findAll($condition = '', $params = [])
 * @method Type[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Type byId(int $id, bool $useAnd = true)
 * @method Type byCode(string $code, bool $useAnd = true)
 */
class Type extends ActiveRecord implements JsonSerializable
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
        return 'EventType';
    }

    public function relations()
    {
        return [
            'EventsCount' => [self::STAT, '\event\models\Event', 'TypeId']
        ];
    }

    /**
     * @return string[]
     */
    public function getTranslationFields()
    {
        return ['Title'];
    }

    /**
     * Specify data which should be serialized to JSON
     *
     * @link  http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        $result = $this->getAttributes([
            'Id',
            'Title'
        ]);

        if ($this->hasRelated('EventsCount')) {
            $result['EventsCount'] = $this->EventsCount;
        }

        return $result;
    }
}