<?php
namespace catalog\models;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property string $Title
 * @property string $Url
 * @property string $CreationTime
 * @property string $UpdateTime
 *
 * Описание вспомогательных методов
 * @method Company   with($condition = '')
 * @method Company   find($condition = '', $params = [])
 * @method Company   findByPk($pk, $condition = '', $params = [])
 * @method Company   findByAttributes($attributes, $condition = '', $params = [])
 * @method Company[] findAll($condition = '', $params = [])
 * @method Company[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Company byId(int $id, bool $useAnd = true)
 * @method Company byTitle(string $title, bool $useAnd = true)
 * @method Company byUrl(string $url, bool $useAnd = true)
 */
class Company extends ActiveRecord
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
        return 'CatalogCompany';
    }

    /**
     * @param bool $serverPath
     * @return string
     */
    public function getLogoForEvent($serverPath = false)
    {
        //todo: реализовать метод, сейчас только заглушка для страницы мероприятий
        return \Yii::app()->params['CatalogCompanyDir'].$this->Id.'/100.png';
    }
}
