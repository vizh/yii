<?php
namespace event\models\section;

use application\models\translation\ActiveRecord;

/**
 * @property int $Id
 * @property int $EventId
 * @property string $Title
 * @property string $UpdateTime
 * @property int $Order
 * @property bool $Deleted
 * @property bool $DeletionTIme
 *
 * Описание вспомогательных методов
 * @method Hall   with($condition = '')
 * @method Hall   find($condition = '', $params = [])
 * @method Hall   findByPk($pk, $condition = '', $params = [])
 * @method Hall   findByAttributes($attributes, $condition = '', $params = [])
 * @method Hall[] findAll($condition = '', $params = [])
 * @method Hall[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Hall byId(int $id, bool $useAnd = true)
 * @method Hall byEventId(int $id, bool $useAnd = true)
 * @method Hall byDeleted(bool $deleted = true, bool $useAnd = true)
 */
class Hall extends ActiveRecord
{
    protected $useSoftDelete = true;

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
        return 'EventSectionHall';
    }

    /**
     * @param string $updateTime
     * @param bool $useAnd
     * @return $this
     */
    public function byUpdateTime($updateTime, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."UpdateTime" > :UpdateTime';
        $criteria->params = ['UpdateTime' => $updateTime];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }

    /**
     * @return \string[]
     */
    public function getTranslationFields()
    {
        return ['Title'];
    }

    protected function beforeSave()
    {
        $this->UpdateTime = date('Y-m-d H:i:s');

        return parent::beforeSave();
    }
}