<?php

namespace application\models\paperless;

use application\components\ActiveRecord;

/**
 * @property int $EventId
 * @property int $MaterialId
 *
 * @property Event $Event
 * @property Material $Material
 *
 * Описание вспомогательных методов
 * @method EventLinkMaterial   with($condition = '')
 * @method EventLinkMaterial   find($condition = '', $params = [])
 * @method EventLinkMaterial   findByPk($pk, $condition = '', $params = [])
 * @method EventLinkMaterial   findByAttributes($attributes, $condition = '', $params = [])
 * @method EventLinkMaterial[] findAll($condition = '', $params = [])
 * @method EventLinkMaterial[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method EventLinkMaterial byEventId(int $id, bool $useAnd = true)
 * @method EventLinkMaterial byMaterialId(int $id, bool $useAnd = true)
 */
class EventLinkMaterial extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function tableName()
    {
        return 'PaperlessEventLinkMaterial';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['EventId, MaterialId', 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function relations()
    {
        return [
            'Event' => [self::BELONGS_TO, Event::className(), ['EventId']],
            'Material' => [self::BELONGS_TO, Material::className(), ['MaterialId']],
        ];
    }
}