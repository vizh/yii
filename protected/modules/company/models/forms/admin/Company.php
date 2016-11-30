<?php
namespace company\models\forms\admin;

use application\components\form\CreateUpdateForm;
use application\components\helpers\ArrayHelper;
use application\components\validators\RangeValidator;
use application\models\ProfessionalInterest;
use commission\models\Commission;
use company\models\Company as CompanyModel;
use company\models\LinkCommission;
use company\models\LinkProfessionalInterest;
use contact\models\forms\Address;
use contact\models\forms\Phone;
use raec\models\forms\admin\CompanyUser;

/**
 * Class Edit
 * @package company\models\forms\admin
 *
 * @method Company getActiveRecord()
 */
class Company extends CreateUpdateForm
{
    public $Name;

    public $FullName;

    public $Code;

    public $Url;

    public $Info;

    public $Logo;

    public $Email;

    public $OGRN;

    /** @var CompanyUser[] */
    public $RaecUsers = [];

    /** @var integer[] */
    public $RaecClusters = [];

    /** @var Moderator[] */
    public $Moderators = [];

    /** @var interger[] */
    public $ProfessionalInterests = [];

    /** @var int */
    public $PrimaryProfessionalInterest;

    /** @var Address */
    public $Address;

    /** @var Phone */
    public $Phone;

    /** @var CompanyModel */
    protected $model = null;

    /**
     * @param Company $model
     */
    public function __construct(CompanyModel $model = null)
    {
        parent::__construct($model);
        $this->Address = new Address($this->isUpdateMode() ? $model->getContactAddress() : null);
        $this->initPhone();
    }

    /**
     * @inheritDoc
     */
    protected function loadData()
    {
        if (parent::loadData()) {
            foreach ($this->model->RaecUsers as $user) {
                $this->RaecUsers[] = new CompanyUser($this->model, $user);
            }
            $this->RaecUsers[] = new CompanyUser($this->model);

            foreach ($this->model->LinkModerators as $link) {
                $this->Moderators[] = new Moderator($this->model, $link);
            }
            $this->Moderators[] = new Moderator($this->model);
            $this->Url = $this->model->getContactSite();
            $this->Email = $this->model->getContactEmail() !== null ? $this->model->getContactEmail()->Email : '';

            foreach ($this->model->RaecClusters as $cluster) {
                $this->RaecClusters[] = $cluster->Id;
            }

            if ($this->model->PrimaryProfessionalInterest !== null) {
                $this->PrimaryProfessionalInterest = $this->model->PrimaryProfessionalInterest->Id;
            }
            foreach ($this->model->ProfessionalInterests as $interests) {
                $this->ProfessionalInterests[] = $interests->Id;
            }
            return true;
        }
        return false;
    }


    /**
     * Инициализация поля телефона
     */
    private function initPhone()
    {
        $phone = null;
        if ($this->isUpdateMode() && !empty($this->model->LinkPhones)) {
            $phone = $this->model->LinkPhones[0]->Phone;
        }
        $this->Phone = new Phone(Phone::ScenarioOneField, $phone);
    }

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            ['Name,FullName,Url', 'filter', 'filter' => '\application\components\utility\Texts::clear'],
            ['Code', 'match', 'pattern' => '/^[a-z0-9]+$/'],
            ['Code', 'unique', 'className' => 'company\models\Company', 'attributeName' => 'Code',
                'criteria' => $this->isUpdateMode() ? ['condition' => '"t"."Id" != :Id', 'params' => ['Id' => $this->model->Id]] : []
            ],
            ['Info', 'safe'],
            ['Name', 'required'],
            ['Url', 'url'],
            ['RaecUsers', 'application\components\validators\MultipleFormValidator', 'when' => function (CompanyUser $form) {
                return $form->isNotEmpty();
            }],
            ['Moderators', 'application\components\validators\MultipleFormValidator', 'when' => function (Moderator $form) {
                return $form->isNotEmpty();
            }],
            ['RaecClusters,ProfessionalInterests', 'filter', 'filter' => 'array_filter'],
            ['RaecClusters', '\application\components\validators\RangeValidator', 'range' => array_keys($this->getClustersData())],
            ['PrimaryProfessionalInterest', 'in', 'range' => array_keys($this->getProfessionalInterestsData())],
            ['ProfessionalInterests', '\application\components\validators\RangeValidator', 'range' => array_keys($this->getProfessionalInterestsData())],
            ['ProfessionalInterests', 'filter', 'filter' => function ($values) {
                foreach ($values as $k => $id) {
                    if ($id == $this->PrimaryProfessionalInterest) {
                        unset($values[$k]);
                    }
                }
                return $values;
            }],
            ['Email', 'email'],
            ['Logo', 'file', 'types' => 'png,jpg', 'allowEmpty' => true],
            ['OGRN', 'numerical', 'integerOnly' => true, 'allowEmpty' => true],
            ['OGRN', 'length', 'is' => 13, 'allowEmpty' => true]
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributeLabels()
    {
        return [
            'RaecUsers' => 'Представители РАЭК',
            'Moderators' => 'Модераторы',
            'Name' => 'Коммерческое название организации (бренд)',
            'FullName' => 'Юридическое название организации',
            'Url' => 'URL сайта компании',
            'Logo' => 'Изображение для логотипа',
            'Address' => 'Адрес организации',
            'Phone' => 'Телефон',
            'RaecClusters' => 'Членство в кластере/комиссии РАЭК',
            'PrimaryProfessionalInterest' => 'Основная экосистема',
            'ProfessionalInterests' => 'Экосистемы',
            'Info' => 'Информация о компании',
            'Code' => 'Символьный код',
            'OGRN' => 'ОГРН',
        ];
    }


    /**
     * @inheritdoc
     */
    public function setAttributes($values, $safeOnly = true)
    {
        $this->RaecUsers  = [];
        $this->Moderators = [];
        if (isset($values['RaecUsers'])) {
            foreach ($values['RaecUsers'] as $attributes) {
                $form = new CompanyUser($this->model);
                $form->setAttributes($attributes);
                $this->RaecUsers[] = $form;
            }
            unset($values['RaecUsers']);
        }
        if (isset($values['Moderators'])) {
            foreach ($values['Moderators'] as $attributes) {
                $form = new Moderator($this->model);
                $form->setAttributes($attributes);
                $this->Moderators[] = $form;
            }
            unset($values['Moderators']);
        }
        return parent::setAttributes($values, $safeOnly);
    }

    /**
     * @inheritDoc
     */
    public function validate($attributes = null, $clearErrors = true)
    {
        $result = parent::validate($attributes, $clearErrors);
        if (!$this->Address->validate()){
            foreach ($this->Address->getErrors() as $messages) {
                $this->addError('Address', $messages[0]);
            }
            $result = false;
        }
        if (!$this->Phone->validate()){
            foreach ($this->Phone->getErrors() as $messages) {
                $this->addError('Phone', $messages[0]);
            }
            $result = false;
        }
        return $result;
    }


    /**
     * @inheritDoc
     */
    public function fillFromPost()
    {
        parent::fillFromPost();
        $this->Logo = \CUploadedFile::getInstance($this, 'Logo');
        $this->Address->fillFromPost();
        $this->Phone->fillFromPost();
    }

    /**
     * @inheritDoc
     */
    public function createActiveRecord()
    {
        $this->model = new CompanyModel();
        return $this->updateActiveRecord();
    }


    /**
     * @inheritDoc
     */
    public function updateActiveRecord()
    {
        if (!$this->validate()) {
            return null;
        }

        $transaction = \Yii::app()->getDb()->beginTransaction();
        try {
            $this->fillActiveRecord();
            $this->model->save();

            if ($this->Logo !== null) {
                $this->model->getLogo()->upload($this->Logo);
            }

            if (!empty($this->Url)) {
                $this->model->setContactSite($this->Url);
            }

            if (!empty($this->Email)) {
                $this->model->setContactEmail($this->Email);
            }

            LinkCommission::model()->deleteAllByAttributes(['CompanyId' => $this->model->Id]);
            foreach (array_unique($this->RaecClusters) as $id) {
                LinkCommission::insertOne([
                    'CompanyId' => $this->model->Id,
                    'CommissionId' => $id
                ]);
            }

            LinkProfessionalInterest::model()->deleteAllByAttributes(['CompanyId' => $this->model->Id]);
            if (!empty($this->PrimaryProfessionalInterest)) {
                LinkProfessionalInterest::insertOne([
                    'CompanyId' => $this->model->Id,
                    'ProfessionalInterestId' => $this->PrimaryProfessionalInterest,
                    'Primary' => true
                ]);
            }

            foreach (array_unique($this->ProfessionalInterests) as $id) {
                LinkProfessionalInterest::insertOne([
                    'CompanyId' => $this->model->Id,
                    'ProfessionalInterestId' => $id
                ]);
            }



            foreach (['RaecUsers', 'Moderators'] as $attribute) {
                /** @var CreateUpdateForm $form */
                foreach ($this->$attribute as $form) {
                    if ($form->isNotEmpty()) {
                        $form->isUpdateMode() ? $form->updateActiveRecord() : $form->createActiveRecord();
                    }
                }
            }

            if ($this->Address->isUpdateMode()) {
                $this->Address->updateActiveRecord();
            } else {
                $this->model->setContactAddress($this->Address->createActiveRecord());
            }

            if ($this->Phone->isUpdateMode()) {
                $this->Phone->updateActiveRecord();
            } else {
                $this->model->setContactPhone($this->Phone->createActiveRecord());
            }

            $transaction->commit();
            return $this->model;
        } catch (\Exception $e) {
            $this->addError('model', $e->getMessage());
            $transaction->rollback();
        }
        return null;
    }

    /**
     * @return array
     */
    public function getClustersData()
    {
        $clusters = Commission::model()->ordered()->findAll();
        return ArrayHelper::merge(
            ['' => \Yii::t('app', 'Не выбран')],
            \CHtml::listData($clusters, 'Id', 'Title')
        );
    }

    /**
     * @return array
     */
    public function getProfessionalInterestsData()
    {
        $interests = ProfessionalInterest::model()->ordered()->findAll();
        return ArrayHelper::merge(
            ['' => \Yii::t('app', 'Не выбран')],
            \CHtml::listData($interests, 'Id', 'Title')
        );
    }
}