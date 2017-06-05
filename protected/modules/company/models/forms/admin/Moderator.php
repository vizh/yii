<?php
namespace company\models\forms\admin;

use application\components\form\CreateUpdateForm;
use company\models\Company;
use company\models\LinkModerator;

/**
 * Class Moderator
 * @package company\models\forms\admin
 *
 * @method LinkModerator getActiveRecord()
 */
class Moderator extends CreateUpdateForm
{

    public $Id;

    public $UserId;

    public $Delete = false;

    /** @var Company */
    private $company;

    public function __construct(Company $company, LinkModerator $model = null)
    {
        parent::__construct($model);
        $this->company = $company;
    }

    /**
     * @inheritDoc
     */
    public function rules()
    {
        $rules = [
            ['UserId', 'required'],
            ['Id', 'exist', 'className' => 'company\models\LinkModerator', 'attributeName' => 'Id'],
            ['UserId', 'exist', 'className' => '\user\models\User', 'attributeName' => 'Id'],
            ['Delete', 'boolean']
        ];
        if (!$this->isUpdateMode()) {
            $rules[] = [
                'UserId',
                'unique',
                'attributeName' => 'UserId',
                'className' => 'company\models\LinkModerator',
                'criteria' => [
                    'condition' => '"t"."CompanyId" = :CompanyId',
                    'params' => ['CompanyId' => $this->company->Id]
                ]
            ];
        }
        return $rules;
    }

    /**
     * @inheritDoc
     */
    public function attributeLabels()
    {
        return [
            'UserId' => \Yii::t('app', 'Пользователь'),
            'Delete' => \Yii::t('app', 'Удалить')
        ];
    }

    /**
     * @inheritdoc
     */
    public function setAttributes($values, $safeOnly = true)
    {
        if (isset($values['Id'])) {
            $this->model = LinkModerator::findOne($values['Id']);
        }
        return parent::setAttributes($values, $safeOnly);
    }

    /**
     * @inheritDoc
     */
    public function createActiveRecord()
    {
        $this->model = new LinkModerator();
        $this->model->CompanyId = $this->company->Id;
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

        $this->fillActiveRecord();
        if ($this->Delete) {
            $this->model->delete();
        } else {
            $this->model->save();
        }
        return $this->model;
    }

}