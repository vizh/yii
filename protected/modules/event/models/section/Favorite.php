<?php
namespace event\models\section;

use application\components\ActiveRecord;
use user\models\User;

/**
 * @property int $Id
 * @property int $SectionId
 * @property int $UserId
 * @property bool $Deleted
 * @property string $UpdateTime
 *
 * @property Section $Section
 * @property User $User
 *
 * Описание вспомогательных методов
 * @method Favorite   with($condition = '')
 * @method Favorite   find($condition = '', $params = [])
 * @method Favorite   findByPk($pk, $condition = '', $params = [])
 * @method Favorite   findByAttributes($attributes, $condition = '', $params = [])
 * @method Favorite[] findAll($condition = '', $params = [])
 * @method Favorite[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Favorite byId(int $id, bool $useAnd = true)
 * @method Favorite bySectionId(int $id, bool $useAnd = true)
 * @method Favorite byUserId(int $id, bool $useAnd = true)
 * @method Favorite byDeleted(bool $deleted, bool $useAnd = true)
 */
class Favorite extends ActiveRecord
{
    /**
     * @param string $className
     * @return Favorite
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'EventSectionFavorite';
    }

    public function relations()
    {
        return [
            'Section' => [self::BELONGS_TO, '\event\models\section\Section', 'SectionId'],
            'User' => [self::BELONGS_TO, '\user\models\User', 'UserId'],
        ];
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

    protected function beforeSave()
    {
        $this->UpdateTime = date('Y-m-d H:i:s');

        return parent::beforeSave();
    }
}