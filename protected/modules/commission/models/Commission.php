<?php
namespace commission\models;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property string $Title
 * @property string $Description
 * @property string $Url
 * @property string $CreationTime
 * @property bool $Deleted
 *
 * @property User[] $Users
 * @property Project[] $Projects
 * @property User[] $UsersActive
 *
 * Описание вспомогательных методов
 * @method Commission   with($condition = '')
 * @method Commission   find($condition = '', $params = [])
 * @method Commission   findByPk($pk, $condition = '', $params = [])
 * @method Commission   findByAttributes($attributes, $condition = '', $params = [])
 * @method Commission[] findAll($condition = '', $params = [])
 * @method Commission[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Commission byId(int $id, bool $useAnd = true)
 * @method Commission byTitle(string $title, bool $useAnd = true)
 * @method Commission byUrl(string $url, bool $useAnd = true)
 * @method Commission byDeleted(bool $deleted, bool $useAnd = true)
 */
class Commission extends ActiveRecord
{
    /**
     * @inheritDoc
     */
    protected $defaultOrderBy = ['"t"."Title"' => SORT_ASC];

    /**
     * @param string $className
     * @return Commission
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'Commission';
    }

    public function relations()
    {
        return [
            'Users' => [self::HAS_MANY, 'commission\models\User', 'CommissionId'],
            'UsersActive' => [self::HAS_MANY, 'commission\models\User', 'CommissionId', 'on' => '"UsersActive"."ExitTime" IS NULL OR "UsersActive"."ExitTime" > NOW()'],
            'Projects' => [self::HAS_MANY, 'commission\models\Project', 'CommissionId'],
        ];
    }

    public function __toString()
    {
        if (!empty($this->Url)) {
            return '<a href="'.$this->Url.'" title="'.$this->Title.'" target="_blank">'.$this->Title.'</a>';
        }

        return $this->Title;
    }
}
