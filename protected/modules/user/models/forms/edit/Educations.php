<?php
namespace user\models\forms\edit;

use application\components\helpers\ArrayHelper;
use geo\models\City;

class Educations extends \user\models\forms\edit\Base
{
    /**
     * @var Education[]
     */
    public $educations = [];

    public function rules()
    {
        return [
            ['educations', 'checkEducations']
        ];
    }

    public function attributeLabels()
    {
        $subForm = new Education();
        return $subForm->attributeLabels();
    }

    /**
     * @param string $attribute
     * @param array $params
     */
    public function checkEducations($attribute, $params)
    {
        if ($attribute != 'educations') {
            return;
        }
        $valid = true;
        foreach ($this->educations as $education) {
            $valid = $valid && $education->validate();
        }
        if (!$valid) {
            $this->addError('educations', \Yii::t('app', 'Ошибка в заполнении образования.'));
        }
    }

    public function addSubform(\user\models\Education $education)
    {
        $form = new Education();
        $form->Id = $education->Id;
        if (!empty($education->University->CityId)) {
            $form->CityId = $education->University->CityId;
            $form->CityName = $education->University->City->Name;
        }
        $form->UniversityId = $education->UniversityId;
        $form->UniversityName = $education->University->Name;
        $form->FacultyId = $education->FacultyId;
        $form->FacultyName = $education->Faculty !== null ? $education->Faculty->Name : '';
        $form->Specialty = $education->Specialty;
        $form->EndYear = $education->EndYear;
        $form->Degree = $education->Degree;
        $this->educations[] = $form;
    }

    public function applyAttributes($attributes)
    {
        if (!empty($attributes['educations'])) {
            foreach ($attributes['educations'] as $education) {
                $form = new Education();
                $form->attributes = $education;
                $this->educations[] = $form;
            }
        }
    }

    public function getJson()
    {
        $result = [];
        foreach ($this->educations as $education) {
            $row = ArrayHelper::toArray($education, [
                'Id',
                'CityId',
                'CityName',
                'UniversityId',
                'UniversityName',
                'FacultyId',
                'FacultyName',
                'Specialty',
                'EndYear',
                'Degree',
                'Delete'
            ]);
            if ($education->hasErrors()) {
                $row['Errors'] = $education->getErrors();
            }
            $row = \CHtml::encodeArray($row);
            $result[] = $row;
        }
        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    public function getEndYearsRange()
    {
        $year = intval(date('Y'));
        $range = ['' => 'Выберите год'];
        for ($i = $year; $i > $year - 60; $i--) {
            $range[$i] = $i;
        }
        return $range;
    }

    /**
     * @return string
     */
    public function getCityDefaultSource()
    {
        $cities = City::model()->limit(10)->ordered()->findAll();
        $source = [];
        foreach ($cities as $city) {
            $source[] = $city->jsonSerialize();
        }
        return json_encode($source);
    }
}