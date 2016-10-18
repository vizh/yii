<?php
namespace partner\models\forms\user;

use application\components\form\CreateUpdateForm;
use company\models\Company;
use user\models\User;

/**
 * Class Translate
 * @package partner\models\forms\user
 */
class Translate extends CreateUpdateForm
{
    /** @var User */
    protected $model;


    private $locale;

    public $FirstName;
    public $LastName;
    public $FatherName;
    public $Company;

    /**
     * @param string $locale
     * @param \CActiveRecord $model
     */
    public function __construct($locale, User $model = null)
    {
        $this->locale = $locale;
        $model->setLocale($this->locale);
        parent::__construct($model);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['FirstName,LastName,FatherName,Company', 'filter', 'filter' => '\application\components\utility\Texts::clear'],
            ['FirstName, LastName', 'required'],
            ['FatherName', 'safe'],
            ['Company', 'validateCompany']
        ];
    }

    /**
     * @param string $attribute
     */
    public function validateCompany($attribute)
    {
        $value = $this->$attribute;
        $employment = $this->model->getEmploymentPrimary();
        if ($employment !== null && empty($value)) {
            $this->addError($attribute, \Yii::t('app', 'Необходимо заполнить поле Компания.'));
            return false;
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'FirstName'  => \Yii::t('app', 'Имя'),
            'LastName'   => \Yii::t('app', 'Фамилия'),
            'FatherName' => \Yii::t('app', 'Отчество'),
            'Company'    => \Yii::t('app', 'Компания'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function fillFromPost()
    {
        $values = [];

        $request = \Yii::app()->getRequest();
        $attributes = $request->getParam(get_class($this));
        foreach ($attributes as $attr => $value) {
            if (isset($value[$this->getLocale()])) {
                $values[$attr] = $value[$this->getLocale()];
            }
        }
        $this->setAttributes($values);
    }

    /**
     * @inheritdoc
     */
    protected function loadData()
    {
        if (parent::loadData()) {
            $employment = $this->model->getEmploymentPrimary();
            if ($employment !== null) {
                $employment->Company->setLocale($this->getLocale());
                $this->Company = $employment->Company->Name;
                $employment->Company->resetLocale();
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function updateActiveRecord()
    {
        if (!$this->validate()) {
            return null;
        }

        $this->model->setLocale($this->getLocale());
        $this->fillActiveRecord();
        $this->model->save();

        $this->model->refresh();
        $employment = $this->model->getEmploymentPrimary();
        if ($employment !== null) {
            if ($this->getLocale() === \Yii::app()->sourceLanguage && $employment->Company->Name !== $this->Company) {
                $company = Company::create($this->Company);
                $employment->CompanyId = $company->Id;
                $employment->save();
            } else {
                $company = $employment->Company;
                $company->setLocale($this->getLocale());
                $company->Name = $this->Company;
                $company->save();
                $company->resetLocale();
            }
        }
        else{
            $this->model->setEmployment($this->Company);
        }
        $this->model->resetLocale();
        return $this->model;
    }


    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }
}
