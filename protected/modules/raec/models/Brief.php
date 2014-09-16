<?php
namespace raec\models;
use user\models\User;

/**
 * Class Brief
 * @property int $Id
 * @property int $UserId
 * @property string $CreationTime
 * @property string $Data
 * @property User $User
 * @package raec\models
 */
class Brief extends \CActiveRecord
{
    /**
     * @param string $className
     * @return Brief
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'RaecBrief';
    }

    public function primaryKey()
    {
        return 'Id';
    }

    public function relations()
    {
        return [
            'User' => [self::BELONGS_TO, '\user\models\User', 'Id']
        ];
    }


} 