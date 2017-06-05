<?php
namespace user\models\forms\admin;

class ListFilter extends \CFormModel
{
    public $Query;
    public $Sort;
    public $PerPage = 20;

    public function rules()
    {
        return [
            ['Sort', 'filter', 'filter' => [$this, 'filterSort']],
            ['Query', 'safe'],
            ['PerPage', 'numerical']
        ];
    }

    /**
     * @param string $value
     * @return string
     */
    public function filterSort($value)
    {
        $model = new \user\models\User();
        $order = explode('_', $value);
        $valid = false;
        if (isset($order[0]) && $model->hasAttribute($order[0]) && isset($order[1]) && in_array($order[1], ['ASC', 'DESC'])) {
            $valid = true;
        }

        if (!$valid) {
            $this->addError('Sort', \Yii::t('app', 'Не верный формат поля {label}.', ['{label}' => $this->getAttributeLabel('Sort')]));
        }
        return $value;
    }

    /**
     * @return string[]
     */
    public function getSortData()
    {
        return [
            'CreationTime_DESC' => \Yii::t('app', 'Дата регистрации ↓'),
            'CreationTime_ASC' => \Yii::t('app', 'Дата регистрации ↑'),
            'LastName_DESC' => \Yii::t('app', 'По фамилии ↓'),
            'LastName_ASC' => \Yii::t('app', 'По фамилии ↑'),
            'RunetId_DESC' => \Yii::t('app', 'RUNET-ID ↓'),
            'RunetId_ASC' => \Yii::t('app', 'RUNET-ID ↑')
        ];
    }

    /**
     * @return int[]
     */
    public function getPerPageData()
    {
        return [
            20 => 20,
            50 => 50,
            100 => 100
        ];
    }
} 