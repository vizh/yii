<?php
namespace event\models\section;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property string $Title
 * @property string $Thesis
 * @property string $Url
 * @property string $FullInfo
 *
 * Описание вспомогательных методов
 * @method Report   with($condition = '')
 * @method Report   find($condition = '', $params = [])
 * @method Report   findByPk($pk, $condition = '', $params = [])
 * @method Report   findByAttributes($attributes, $condition = '', $params = [])
 * @method Report[] findAll($condition = '', $params = [])
 * @method Report[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Report byId(int $id, bool $useAnd = true)
 */
class Report extends ActiveRecord
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
        return 'EventSectionReport';
    }
}