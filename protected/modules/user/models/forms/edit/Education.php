<?php
namespace user\models\forms\edit;

use application\components\utility\Texts;
use education\models\Degree;
use education\models\Faculty;
use education\models\University;
use geo\models\City;

class Education extends \user\models\forms\edit\Base
{
    public $Id;
    public $CityName;
    public $CityId;
    public $UniversityName;
    public $UniversityId;
    public $FacultyName;
    public $FacultyId;
    public $Specialty;
    public $EndYear;
    public $Degree;
    public $Delete = 0;

    public function rules()
    {
        return [
            ['Specialty', 'filter', 'filter' => '\application\components\utility\Texts::clear'],
            ['Specialty', 'required'],
            ['CityId', 'filter', 'filter' => [$this, 'filterCity']],
            ['UniversityId', 'checkUniversity'],
            ['FacultyId', 'checkFaculty'],
            ['EndYear', 'checkEndYear'],
            ['Degree', 'in', 'range' => array_keys(Degree::getAll()), 'allowEmpty' => true],
            ['CityName, UniversityName, FacultyName, Delete, Id', 'safe']
        ];
    }

    /**
     *
     */
    public function filterCity($cityId)
    {
        $cityId = intval($cityId);
        if ($cityId === 0) {
            $this->addError('CityName', 'Необходимо выбрать город.');
        } elseif (City::model()->findByPk($cityId) === null) {
            $this->addError('CityName', 'Указанный город не найден.');
        }
        return $cityId;
    }

    /**
     * @param string $attribute
     * @param array $params
     */
    public function checkUniversity($attribute, $params)
    {
        $this->UniversityId = intval($this->UniversityId);
        $this->UniversityName = Texts::clear($this->UniversityName);

        if ($this->UniversityId === 0 && empty($this->UniversityName)) {
            $this->addError('UniversityName', 'Необходимо выбрать ВУЗ из списка или указать свой.');
        } elseif ($this->UniversityId !== 0) {
            $university = University::model()->findByPk($this->UniversityId);
            if ($university === null) {
                $this->addError('UniversityName', 'Указанный ВУЗ не найден.');
            } elseif ($university->CityId != $this->CityId) {
                $this->addError('UniversityName', 'Указанный ВУЗ не соответствует городу.');
            }
        }
    }

    /**
     * @param string $attribute
     * @param array $params
     */
    public function checkFaculty($attribute, $params)
    {
        $this->FacultyId = intval($this->FacultyId);
        $this->FacultyName = Texts::clear($this->FacultyName);

        if ($this->FacultyId !== 0) {
            $faculty = Faculty::model()->findByPk($this->FacultyId);
            if ($faculty === null) {
                $this->addError('FacultyName', 'Указанный факультет не найден.');
            } elseif ($faculty->UniversityId != $this->UniversityId) {
                $this->addError('FacultyName', 'Указанный факультет не соответствует ВУЗу.');
            }
        }
    }

    /**
     * @param string $attribute
     * @param array $params
     */
    public function checkEndYear($attribute, $params)
    {
        if ($this->EndYear !== null) {
            $this->EndYear = intval($this->EndYear);
            if ($this->EndYear === 0) {
                $this->addError('EndYear', 'Необходимо указать год выпуска.');
            }
        }
    }

    public function process()
    {
        $education = null;
        $this->Id = intval($this->Id);
        if ($this->Id !== 0) {
            $education = \user\models\Education::model()->findByPk($this->Id);
            if ($education !== null && $this->Delete) {
                $education->delete();
                return;
            }
        }
        if ($education === null) {
            $education = new \user\models\Education();
            $education->UserId = \Yii::app()->user->getCurrentUser()->Id;
        }
        $education->UniversityId = $this->getUniversity()->Id;
        $faculty = $this->getFaculty($education->UniversityId);
        $education->FacultyId = $faculty !== null ? $faculty->Id : null;
        $education->Specialty = $this->Specialty;
        $education->EndYear = $this->EndYear;
        $education->Degree = !empty($this->Degree) ? $this->Degree : null;
        $education->save();
    }

    /**
     * @return University
     */
    private function getUniversity()
    {
        if ($this->UniversityId != 0) {
            $university = University::model()->findByPk($this->UniversityId);
            if (empty($this->UniversityName) || $university->Name == $this->UniversityName) {
                return $university;
            }
        }

        $university = new University();
        $university->CityId = $this->CityId;
        $university->Name = $this->UniversityName;
        $university->save();
        return $university;
    }

    /**
     * @param int $universityId
     * @return Faculty|null
     */
    private function getFaculty($universityId)
    {
        if ($this->FacultyId != 0) {
            $faculty = Faculty::model()->findByPk($this->FacultyId);
            if (empty($this->FacultyName) || $faculty->Name == $this->FacultyName) {
                return $faculty;
            }
        }

        $faculty = null;
        if (!empty($this->FacultyName)) {
            $faculty = new Faculty();
            $faculty->UniversityId = $universityId;
            $faculty->Name = $this->FacultyName;
            $faculty->save();
        }
        return $faculty;
    }

    public function attributeLabels()
    {
        return [
            'CityId' => \Yii::t('app', 'Город'),
            'CityName' => \Yii::t('app', 'Город'),
            'UniversityId' => \Yii::t('app', 'Университет'),
            'UniversityName' => \Yii::t('app', 'Университет'),
            'FacultyName' => \Yii::t('app', 'Факультет'),
            'Specialty' => \Yii::t('app', 'Специальность'),
            'EndYear' => \Yii::t('app', 'Год выпуска'),
            'Degree' => \Yii::t('app', 'Степень')
        ];
    }
}