<?php
namespace raec\models\forms\brief;

use CEvent;
use company\models\Company;

class About extends \CFormModel
{
    public $CompanyLabel;
    public $CompanyId;
    public $CompanySynonyms = [];

    public $CEOFirstName;
    public $CEOLastName;
    public $CEOFatherName;
    public $CEOPosition;
    public $CEOPositionBase;

    public $BookerFirstName;
    public $BookerLastName;
    public $BookerFatherName;

    public $JuridicalOPF;
    public $JuridicalShortName;
    public $JuridicalFullName;
    public $JuridicalAddress;
    public $JuridicalAddressActual;
    public $JuridicalAddressEqual = 0;
    public $JurudicalINN;
    public $JurudicalOGRN;
    public $JurudicalOGRNDate;
    public $JurudicalBIK;
    public $JuridicalKPP;
    public $JuridicalBankName;
    public $JurudicalAccount;
    public $JurudicalCorrAccount;

    public function rules()
    {
        return [
            ['CompanyLabel,CEOFirstName,CEOLastName,CEOFatherName,CEOPosition,CEOPositionBase,BookerFirstName,BookerLastName,BookerFatherName,JuridicalOPF,JuridicalShortName,JuridicalFullName,JuridicalAddress,JuridicalAddressActual,JurudicalINN,JurudicalOGRN,JurudicalOGRNDate,JurudicalBIK,JuridicalKPP,JuridicalBankName,JurudicalAccount,JurudicalCorrAccount', 'required'],
            ['CompanyId', 'exist', 'className' => '\company\models\Company', 'attributeName' => 'Id', 'allowEmpty' => true],
            ['JuridicalOPF', 'in', 'range' => $this->getJuridicalOPFData()],
            ['JurudicalOGRNDate', 'date', 'format' => 'dd.MM.yyyy'],
            ['CompanySynonyms', 'validateCompanySynonyms'],
            ['JuridicalAddressEqual', 'boolean']
        ];
    }

    protected function afterValidate()
    {
        $errors = $this->errors;
        foreach ($this->errors as $attribute => $messages) {
            $label = $this->getAttributeLabel($attribute);
            if (strpos($attribute, 'CEO') === 0) {
                foreach ($messages as $i => $message) {
                    $errors[$attribute][$i] = str_replace($label, $label.' '.\Yii::t('app', 'руководителя'), $message);
                }
            } elseif (strpos($attribute, 'Booker') === 0) {
                foreach ($messages as $i => $message) {
                    $errors[$attribute][$i] = str_replace($label, $label.' '.\Yii::t('app', 'главного бухгалтера'), $message);
                }
            }

        }
        $this->clearErrors();
        $this->addErrors($errors);
        parent::afterValidate();
    }


    public function attributeLabels()
    {
        return [
            'CompanyLabel' => \Yii::t('app', 'Название компании'),
            'CompanyId' => \Yii::t('app', 'Компания'),
            'CompanySynonyms' => \Yii::t('app', 'Дочерние компании'),
            'CEOFirstName' => \Yii::t('app', 'Имя'),
            'CEOLastName' => \Yii::t('app', 'Фамилия'),
            'CEOFatherName' => \Yii::t('app', 'Отчество'),
            'CEOPosition' => \Yii::t('app', 'Должность'),
            'CEOPositionBase' => \Yii::t('app', 'Основание назначения'),
            'BookerFirstName' => \Yii::t('app', 'Имя'),
            'BookerLastName' => \Yii::t('app', 'Фамилия'),
            'BookerFatherName' => \Yii::t('app', 'Отчество'),
            'JuridicalOPF' => \Yii::t('app', 'Тип'),
            'JuridicalShortName' => \Yii::t('app', 'Краткое наименование'),
            'JuridicalFullName' => \Yii::t('app', 'Полное наименование'),
            'JuridicalAddress' => \Yii::t('app', 'Юридический адрес'),
            'JuridicalAddressActual' => \Yii::t('app', 'Фактический адрес'),
            'JurudicalINN' => \Yii::t('app', 'ИНН'),
            'JurudicalOGRN' => \Yii::t('app', 'ОГРН'),
            'JurudicalOGRNDate' => \Yii::t('app', 'Дата ОГРН'),
            'JurudicalBIK' => \Yii::t('app', 'БИК'),
            'JuridicalKPP' => \Yii::t('app', 'КПП'),
            'JuridicalBankName' => \Yii::t('app', 'Наименование банка'),
            'JurudicalAccount' => \Yii::t('app', 'Расчетный счет'),
            'JurudicalCorrAccount' => \Yii::t('app', 'Корреспондентский счет'),
            'JuridicalAddressEqual' => \Yii::t('app', 'Совпадает с юридическим')
        ];
    }

    public function getJuridicalOPFData()
    {
        $data = [
            'ГП', 'ООО', 'ЧП', 'НПП', 'ЗАО', 'ОАО', 'ТРК', 'ДчП', 'ОДО', 'ОТП', 'Общественная Организация', 'НПЧП', 'ПТК ЧП', 'НИПИ', 'СП', 'НПФ'
        ];
        return array_combine($data, $data);
    }

    public function validateCompanySynonyms($attribute)
    {
        $valid = true;
        if (is_array($this->$attribute)) {
            foreach ($this->$attribute as $value) {
                $label = trim($value['Label']);
                if (empty($label) && empty($value['Id'])) {
                    $valid = false;
                } elseif (!empty($value['Id'])) {
                    $exists = Company::model()->findByPk($value['Id']);
                    if ($exists == null) {
                        $valid = false;
                    }
                }

                if (!$valid) {
                    break;
                }
            }
        } else {
            $valid = false;
        }

        if (!$valid)
            $this->addError($attribute, \Yii::t('app', 'Ошибка в заполнение поля {label}', ['{label}' => $this->getAttributeLabel($attribute)]));
    }

}