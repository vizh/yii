<?php
namespace competence\models\test\education15;

use competence\models\form\Base;
use competence\models\Result;
use education\models\University;
use user\models\Education;
use user\models\User;

class Q1 extends Base
{
    public $Speciality;

    public $University;
    public $UniversityLabel;

    public function init()
    {
        $education = $this->getUserEducation();
        if ($education !== null) {
            $this->University = $education->University->Id;
            $this->UniversityLabel = $education->University->Name;
            $this->Speciality = $education->Specialty;
        }
        parent::init();
    }


    public function attributeLabels()
    {
        return [
            'UniversityLabel' => 'Высшее учебное заведение',
            'Speciality' => 'Специальность'
        ];
    }

    public function rules()
    {
        return [
            ['Speciality,UniversityLabel', 'filter', 'filter' => '\application\components\utility\Texts::clear'],
            ['University', 'validateUniversity'],
            ['Speciality', 'required'],
            ['UniversityLabel', 'safe']
        ];
    }

    /**
     * @param string $attribute
     * @param array $params
     */
    public function validateUniversity($attribute, $params)
    {
        $this->University = intval($this->University);
        if (empty($this->University) && empty($this->UniversityLabel)) {
            $this->addError('UniversityLabel', 'Необходимо выбрать ВУЗ из списка или указать свой.');
        } elseif (!empty($this->University)) {
            $university = University::model()->findByPk($this->University);
            if ($university === null) {
                $this->addError('UniversityLabel', 'Указанный ВУЗ не найден.');
            }
        }
    }

    /**
     * @return null|Education
     */
    private function getUserEducation()
    {
        /** @var User $user */
        $user = \Yii::app()->getUser()->getCurrentUser();
        if (!empty($user->Educations)) {
            return $user->Educations[0];
        }
        return null;
    }

    /**
     * @return array
     */
    protected function getFormData()
    {
        return [
            'University' => $this->getUniversity()->Id,
            'UniversityLabel' => $this->getUniversity()->Name,
            'Speciality' => $this->Speciality
        ];
    }

    /**
     * @inheritdoc
     */
    public function afterProcess()
    {
        $education = $this->getUserEducation();
        if ($education !== null && $education->UniversityId == $this->University && $education->Specialty == $this->Speciality) {
            return;
        } else {
            $education = new Education();
            $education->UserId = \Yii::app()->user->getCurrentUser()->Id;
            $education->UniversityId = $this->getUniversity()->Id;
            $education->Specialty = $this->Speciality;
            $education->save();
        }
    }

    /**
     * @return University
     */
    private function getUniversity()
    {
        if (!empty($this->University)) {
            $university = University::model()->findByPk($this->University);
            if (empty($this->UniversityLabel) || $university->Name == $this->UniversityLabel) {
                return $university;
            }
        }

        $university = new University();
        $university->Name = $this->UniversityLabel;
        $university->save();
        return $university;
    }

    /**
     * @inheritdoc
     */
    protected function getInternalExportValueTitles()
    {
        $titles = ['ВУЗ', 'Специальность'];
        return $titles;
    }

    /**
     * @inheritdoc
     */
    protected function getInternalExportData(Result $result)
    {
        $questionData = $result->getQuestionResult($this->question);
        /** @var University $education */
        $university = University::model()->findByPk($questionData['University']);
        $speciality = $questionData['Speciality'];
        return [
            $university->Name,
            $speciality
        ];
    }


}
