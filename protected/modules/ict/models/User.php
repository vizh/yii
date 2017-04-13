<?php
namespace ict\models;

use application\components\ActiveRecord;
use application\models\ProfessionalInterest;

/**
 * This is the model class for table "IctUser".
 *
 * The followings are the available columns in table 'IctUser':
 *
 * @property integer $Id
 * @property integer $UserId
 * @property integer $RoleId
 * @property string $JoinTime
 * @property string $ExitTime
 * @property string $Type
 * @property integer $ProfessionalInterestId
 *
 * @property \user\models\User $User
 * @property Role $Role
 * @property ProfessionalInterest $ProfessionalInterest
 *
 * Описание вспомогательных методов
 * @method User   with($condition = '')
 * @method User   find($condition = '', $params = [])
 * @method User   findByPk($pk, $condition = '', $params = [])
 * @method User   findByAttributes($attributes, $condition = '', $params = [])
 * @method User[] findAll($condition = '', $params = [])
 * @method User[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method User byId(int $id, bool $useAnd = true)
 * @method User byUserId(int $id, bool $useAnd = true)
 * @method User byRoleId(int $id, bool $useAnd = true)
 * @method User byType(string $type, bool $useAnd = true)
 * @method User byProfessionalInterestId(int $profinterest, bool $useAnd = true)
 */
class User extends ActiveRecord
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

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'IctUser';
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return [
            'User' => [self::BELONGS_TO, '\user\models\User', 'UserId'],
            'Role' => [self::BELONGS_TO, '\ict\models\Role', 'RoleId'],
            'ProfessionalInterest' => [self::BELONGS_TO, '\application\models\ProfessionalInterest', 'ProfessionalInterestId']
        ];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $result = $this->Role->Title;
        if (!empty($this->ProfessionalInterest)) {
            $result .= ', '.\Yii::t('app', 'экосистема').' «'.$this->ProfessionalInterest->Title.'»';
        }

        return $result;
    }

}