<?php
namespace event\models\section;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property int $SectionId
 * @property int $ThemeId
 *
 * @property Section $Section
 * @property Theme $Theme
 *
 * Описание вспомогательных методов
 * @method LinkTheme   with($condition = '')
 * @method LinkTheme   find($condition = '', $params = [])
 * @method LinkTheme   findByPk($pk, $condition = '', $params = [])
 * @method LinkTheme   findByAttributes($attributes, $condition = '', $params = [])
 * @method LinkTheme[] findAll($condition = '', $params = [])
 * @method LinkTheme[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method LinkTheme byId(int $id, bool $useAnd = true)
 * @method LinkTheme bySectionId(int $id, bool $useAnd = true)
 * @method LinkTheme byThemeId(int $id, bool $useAnd = true)
 */
class LinkTheme extends ActiveRecord
{
    /**
     * @param string $className
     *
     * @return LinkTheme
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'EventSectionLinkTheme';
    }

    public function relations()
    {
        return [
            'Section' => [self::BELONGS_TO, '\event\models\section\Section', 'SectionId'],
            'Theme' => [self::BELONGS_TO, '\event\models\section\Theme', 'ThemeId'],
        ];
    }
}
