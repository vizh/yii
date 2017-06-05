<?php
namespace company\models\search\admin;

use application\components\form\SearchFormModel;
use company\models\Company as CompanyModel;

class Company extends SearchFormModel
{
    public $Name;

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            ['Name', 'filter', 'filter' => 'application\components\utility\Texts::clear']
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributeLabels()
    {
        return [
            'Name' => 'Компания',
            'Moderators' => 'Модераторов',
            'Employments' => 'Сотрудников'
        ];
    }

    /**
     * @return \CDataProvider
     */
    public function getDataProvider()
    {
        $model = CompanyModel::model()->with(['RaecUsers', 'LinkModerators', 'EmploymentsAllWithInvisible']);
        if ($this->validate()) {
            if (!empty($this->Name)) {
                $model->bySearch($this->Name);
            }
        }

        return new \CActiveDataProvider('company\models\Company', [
            'criteria' => $model->getDbCriteria()
        ]);
    }
}