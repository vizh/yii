<?php
namespace user\models;

use education\models\Faculty;
use education\models\University;

/**
 * Class Education
 * @package user\models
 *
 * @property int $Id
 * @property int $UserId
 * @property int $UniversityId
 * @property int $FacultyId
 * @property string $Specialty
 * @property int $EndYear
 * @property string $Degree
 *
 *
 * @property User $User
 * @property University $University
 * @property Faculty $Faculty
 *
 *
 * @method Education find($condition='',$params=array())
 * @method Education findByPk($pk,$condition='',$params=array())
 * @method Education[] findAll($condition='',$params=array())
 */
class Education extends \CActiveRecord
{
    /**
     * @param string $className
     * @return Education
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'UserEducation';
    }

    public function primaryKey()
    {
        return 'Id';
    }

    public function relations()
    {
        return [
            'User' => [self::BELONGS_TO, 'user\models\User', 'UserId'],
            'University' => [self::BELONGS_TO, 'education\models\University', 'UniversityId'],
            'Faculty' => [self::BELONGS_TO, 'education\models\Faculty', 'FacultyId']
        ];
    }

    /**
     *
     */
    protected function afterSave()
    {
        if ($this->getIsNewRecord()) {
            $city = $this->University->City;
            if ($city !== null) {
                $city->incrementPriority();
            }
        }
        return parent::afterSave();
    }


}