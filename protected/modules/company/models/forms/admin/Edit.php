<?php
namespace company\models\forms\admin;

use application\components\form\CreateUpdateForm;
use company\models\Company;
use raec\models\forms\admin\CompanyUser;

/**
 * Class Edit
 * @package company\models\forms\admin
 *
 * @method Company getActiveRecord()
 */
class Edit extends CreateUpdateForm
{
    public $Name;

    public $FullName;

    public $Url;

    public $Logo;

    /** @var CompanyUser[] */
    public $RaecUsers = [];

    /** @var Moderator[] */
    public $Moderators = [];

    /**
     * @param Company $model
     */
    public function __construct(Company $model = null)
    {
        parent::__construct($model);
        if ($model !== null) {
            foreach ($model->RaecUsers as $user) {
                $this->RaecUsers[] = new CompanyUser($model, $user);
            }
            $this->RaecUsers[] = new CompanyUser($model);

            foreach ($model->LinkModerators as $link) {
                $this->Moderators[] = new Moderator($model, $link);
            }
            $this->Moderators[] = new Moderator($model);
        }
    }

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            ['Name,FullName,Url', 'filter', 'filter' => '\application\components\utility\Texts::clear'],
            ['Name', 'required'],
            ['Url', 'url'],
            ['RaecUsers', 'application\components\validators\MultipleFormValidator', 'when' => function (CompanyUser $form) {
                return $form->isNotEmpty();
            }],
            ['Moderators', 'application\components\validators\MultipleFormValidator', 'when' => function (Moderator $form) {
                return $form->isNotEmpty();
            }]
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
            'Logo' => 'Изображение для логотипа'
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
    public function updateActiveRecord()
    {
        if (!$this->validate()) {
            return null;
        }

        $transaction = \Yii::app()->getDb()->beginTransaction();
        try {
            $this->fillActiveRecord();
            foreach (['RaecUsers', 'Moderators'] as $attribute) {
                /** @var CreateUpdateForm $form */
                foreach ($this->$attribute as $form) {
                    if ($form->isNotEmpty()) {
                        $form->isUpdateMode() ? $form->updateActiveRecord() : $form->createActiveRecord();
                    }
                }
            }
            $transaction->commit();
            return $this->model;
        } catch (\Exception $e) {
            $this->addError('model', $e->getMessage());
            $transaction->rollback();
        }
        return null;
    }


}