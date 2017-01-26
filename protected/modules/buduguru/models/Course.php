<?php
namespace buduguru\models;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property string $Name
 * @property string $Announce
 * @property string $Url
 * @property string $DateStart
 *
 * Описание вспомогательных методов
 * @method Course   with($condition = '')
 * @method Course   find($condition = '', $params = [])
 * @method Course   findByPk($pk, $condition = '', $params = [])
 * @method Course   findByAttributes($attributes, $condition = '', $params = [])
 * @method Course[] findAll($condition = '', $params = [])
 * @method Course[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Course byId(int $id, bool $useAnd = true)
 * @method Course byName(string $name, bool $useAnd = true)
 * @method Course byAnnounce(string $announce, bool $useAnd = true)
 * @method Course byUrl(string $url, bool $useAnd = true)
 * @method Course byDateStart(string $dateStart, bool $useAnd = true)
 */
class Course extends ActiveRecord
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
        return 'BuduGuruCourse';
    }
}