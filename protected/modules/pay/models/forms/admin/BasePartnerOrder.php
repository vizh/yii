<?php
namespace pay\models\forms\admin;

use application\components\form\CreateUpdateForm;

/**
 * Class BasePartnerOrder
 *
 * @property-read string $owner
 *
 */
abstract class BasePartnerOrder extends CreateUpdateForm
{
    public $Name;
    public $Address;
    public $INN;
    public $KPP;
    public $BankName;
    public $Account;
    public $CorrespondentAccount;
    public $BIK;
    public $ChiefName;
    public $ChiefPosition;
    public $ChiefNameP;
    public $ChiefPositionP;

    public $StatuteTitle = 'Устава';
    public $RealAddress;

    private $owner;

    /**
     * @param string $owner
     * @param \CActiveRecord $model
     */
    public function __construct($owner, \CActiveRecord $model = null)
    {
        parent::__construct($model);
        $this->owner = $owner;
    }

    public function rules()
    {
        return [
            ['Name, Address, INN, KPP, BankName, Account, CorrespondentAccount, BIK, ChiefName, ChiefPosition, ChiefNameP, ChiefPositionP, StatuteTitle', 'required'],
            ['RealAddress', 'safe']
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'Name' => \Yii::t('app', 'Название организации'),
            'Address' => \Yii::t('app', 'Юридический адрес'),
            'INN' => \Yii::t('app', 'ИНН'),
            'KPP' => \Yii::t('app', 'KПП'),
            'BankName' => \Yii::t('app', 'Банк'),
            'Account' => \Yii::t('app', 'Расчетный счет'),
            'CorrespondentAccount' => \Yii::t('app', 'Кор. счет'),
            'BIK' => \Yii::t('app', 'БИК'),
            'ChiefName' => \Yii::t('app', 'Имя руководителя'),
            'ChiefPosition' => \Yii::t('app', 'Должность руководителя'),
            'ChiefNameP' => \Yii::t('app', 'Имя руководителя (в род. падеже)'),
            'ChiefPositionP' => \Yii::t('app', 'Должность руководителя(в род. падеже)'),
            'RealAddress' => \Yii::t('app', 'Фактический адрес'),
            'StatuteTitle' => \Yii::t('app', 'Действующего на основании (в род. падаже, с большой буквы)'),
        ];
    }

    /**
     * @return string
     */
    public function getOwner()
    {
        return $this->owner;
    }
} 