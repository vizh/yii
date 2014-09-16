<?php
namespace raec\models\forms\brief;

use application\models\ProfessionalInterest;

class Resume extends \CFormModel
{
    public $Year;
    public $ProfessionalInterest = [];
    public $Customers;
    public $Progress;
	public $Employees;
    public $Additional;

    public function rules()
    {
        return [
            ['Year,ProfessionalInterest,Progress,Employees', 'required'],
            ['Customers,Additional', 'type', 'type' => 'string'],
            ['Year', 'date', 'format' => 'yyyy'],
            ['ProfessionalInterest', 'professionalInterestValidate']
        ];
    }

    public function attributeLabels()
    {
        return [
            'Year' => \Yii::t('app', 'Год основания'),
            'ProfessionalInterest' => \Yii::t('app', 'Cфера деятельности'),
            'Progress' => \Yii::t('app', 'Главные достижения'),
            'Employees' => \Yii::t('app', 'Информация о коллективе и руководстве'),
            'Customers' => \Yii::t('app', 'Информация о клиентах'),
            'Additional' => \Yii::t('app', 'Дополнительная информация')
        ];
    }

    /**
     * @return array
     */
    public function getProfessionalInterestData()
    {
        $criteria = new \CDbCriteria();
        $criteria->order = '"t"."Title" ASC';
        $interests = ProfessionalInterest::model()->findAll();
        return \CHtml::listData($interests, 'Id', 'Title');
    }

    /**
     * @param $attribute
     */
    public function professionalInterestValidate($attribute)
    {
        $valid = true;
        if (is_array($this->$attribute)) {
            $keys = array_keys($this->getProfessionalInterestData());
            foreach ($this->$attribute as $id) {
                if (!in_array($id, $keys)) {
                    $valid = false;
                }
            }
        } else {
            $valid = false;
        }

        if (!$valid)
            $this->addError($attribute, \Yii::t('app', '{label} отсутствует в списке.', ['{label}' => $this->getAttributeLabel($attribute)]));
    }
} 