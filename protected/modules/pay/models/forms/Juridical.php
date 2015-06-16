<?php
namespace pay\models\forms;

use application\components\form\CreateUpdateForm;
use pay\models\Order;
use pay\models\OrderJuridical;

class Juridical extends CreateUpdateForm
{
    public $Name;

    public $Address;

    public $INN;

    public $KPP;

    public $Phone;

    public $PostAddress;

    /** @var Order */
    private $order;

    public function __construct(Order $model = null)
    {
        $this->order = $model;
        parent::__construct($model->OrderJuridical);
    }


    public function rules()
    {
        return [
            ['Name, Address, INN, KPP, Phone, PostAddress', 'filter', 'filter' => '\application\components\utility\Texts::clear'],
            ['Name, Address, INN, KPP, Phone', 'required'],
            ['PostAddress', 'safe']
        ];
    }

    public function setAttributes($values, $safeOnly = true)
    {
        if (empty($values['PostAddress'])) {
            $values['PostAddress'] = isset($values['Address']) ? $values['Address'] : '';
        }
        parent::setAttributes($values, $safeOnly);
    }


    public function attributeLabels()
    {
        return [
            'Name' => \Yii::t('app', 'Название компании'),
            'Address' => \Yii::t('app', 'Юридический адрес (с индексом)'),
            'INN' => \Yii::t('app', 'ИНН'),
            'KPP' => \Yii::t('app', 'КПП'),
            'Phone' => \Yii::t('app', 'Телефон'),
            'PostAddress' => \Yii::t('app', 'Почтовый адрес (с индексом)'),
        ];
    }

    /**
     * @return \CActiveRecord|null
     */
    public function updateActiveRecord()
    {
        if (!$this->validate()) {
            return null;
        }

        $this->fillActiveRecord();
        $this->model->save();
        return $this->model;
    }


}
