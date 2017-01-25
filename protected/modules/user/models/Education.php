<?php
namespace user\models;

use application\components\ActiveRecord;
use education\models\Faculty;
use education\models\University;

/**
 * @property int $Id
 * @property int $UserId
 * @property int $UniversityId
 * @property int $FacultyId
 * @property string $Specialty
 * @property int $EndYear
 * @property string $Degree
 *
 * @property User $User
 * @property University $University
 * @property Faculty $Faculty
 *
 * Описание вспомогательных методов
 * @method Education   with($condition = '')
 * @method Education   find($condition = '', $params = [])
 * @method Education   findByPk($pk, $condition = '', $params = [])
 * @method Education   findByAttributes($attributes, $condition = '', $params = [])
 * @method Education[] findAll($condition = '', $params = [])
 * @method Education[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Education byId(int $id, bool $useAnd = true)
 * @method Education byUserId(int $id, bool $useAnd = true)
 * @method Education byUniversityId(int $id, bool $useAnd = true)
 * @method Education byFacultyId(int $id, bool $useAnd = true)
 */
class Education extends ActiveRecord
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
        return 'UserEducation';
    }

    public function relations()
    {
        return [
            'User' => [self::BELONGS_TO, 'user\models\User', 'UserId'],
            'University' => [self::BELONGS_TO, 'education\models\University', 'UniversityId'],
            'Faculty' => [self::BELONGS_TO, 'education\models\Faculty', 'FacultyId']
        ];
    }
}