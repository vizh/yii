<?php
namespace pay\models\forms\admin;

class Account extends \CFormModel
{
    private $account;

    public $EventId;
    public $EventTitle;
    public $Own;
    public $OrderTemplateId;
    public $ReturnUrl;
    public $Offer;
    public $OfferFile;
    public $OrderLastTime;
    public $Uniteller;
    public $UnitellerRuvents;
    public $PayOnline;
    public $MailRuMoney;
    public $ReceiptTemplateId;
    public $ReceiptLastTime;
    public $OrderMinTotal;
    public $OrderMinTotalMessage;

    /**
     *
     * @param \pay\models\Account $account
     * @param string $scenario
     */
    public function __construct($account, $scenario = '')
    {
        parent::__construct($scenario);
        $this->account = $account;
    }

    public function rules()
    {
        return [
            ['EventId,EventTitle,Own', 'required'],
            ['Offer', 'type', 'type' => 'string', 'allowEmpty' => true],
            ['OrderTemplateId, ReceiptTemplateId', 'exist', 'className' => '\pay\models\OrderJuridicalTemplate', 'attributeName' => 'Id', 'allowEmpty' => true],
            ['ReturnUrl', 'url', 'allowEmpty' => true],
            ['OrderLastTime, ReceiptLastTime', 'date', 'format' => 'dd.MM.yyyy', 'allowEmpty' => true],
            ['OfferFile', 'file', 'types' => 'pdf,doc,docx', 'allowEmpty' => true],
            ['EventId', 'filter', 'filter' => [$this, 'filterEventId']],
            ['Uniteller,UnitellerRuvents,PayOnline,MailRuMoney', 'numerical', 'max' => 1, 'min' => 1, 'allowEmpty' => true],
            ['OrderMinTotal', 'type', 'type' => 'integer', 'allowEmpty' => true],
            ['OrderMinTotalMessage', 'safe']
        ];
    }

    public function getAccount()
    {
        return $this->account;
    }

    public function attributeLabels()
    {
        return [
            'EventId' => \Yii::t('app', 'ID мероприятия'),
            'EventTitle' => \Yii::t('app', 'Название мероприятия'),
            'Own' => \Yii::t('app', 'Собственное мероприятие'),
            'OrderTemplateId' => \Yii::t('app', 'Шаблон для счетов'),
            'ReturnUrl' => \Yii::t('app', 'URL после оплаты'),
            'Offer' => \Yii::t('app', 'Оферта'),
            'OfferFile' => \Yii::t('app', 'Файл с офертой'),
            'OrderLastTime' => \Yii::t('app', 'Последняя дата выставления счета'),
            'OrderEnable' => \Yii::t('app', 'Разрешить выставлять счета'),
            'Uniteller' => \Yii::t('app', 'Использовать платежную систему Uniteller'),
            'UnitellerRuvents' => \Yii::t('app', 'Использовать платежную систему Uniteller (ООО РУВЕНТС)'),
            'PayOnline' => \Yii::t('app', 'Использовать платежную систему PayOnline'),
            'MailRuMoney' => \Yii::t('app', 'Использовать платежную систему MailRuMoney'),
            'PaySystem' => \Yii::t('app', 'Платежная система'),
            'ReceiptTemplateId' => \Yii::t('app', 'Шаблон для квитанций'),
            'ReceiptLastTime' => \Yii::t('app', 'Последняя дата выставления квитанций'),
            'OrderMinTotal' => \Yii::t('app', 'Минимальная сумма для выставления юр. счета'),
            'OrderMinTotalMessage' => \Yii::t('app', 'Сообщение при невозможности выставить счет из-за минимальной суммы'),
        ];
    }

    public function filterEventId($value)
    {
        if ($this->account->getIsNewRecord() && !$this->hasErrors('EventId'))
        {
            $account = \pay\models\Account::model()->byEventId($this->EventId)->find();
            if ($account !== null)
            {
                $this->addError('EventId', \Yii::t('app', 'Платежный аккаунт для этого мероприятия уже существует. Для его редактирования перейдите по <a href="{link}">ссылке</a>.', [
                    '{link}' => \Yii::app()->getController()->createUrl('/pay/admin/account/edit', ['accountId' => $account->Id])
                ]));
            }
        }
        return $value;
    }

    public function getOrderTemplateData()
    {
        $data = ['' => \Yii::t('app', 'Не задан')];
        $templates = \pay\models\OrderJuridicalTemplate::model()->findAll(['order' => '"t"."Title" ASC']);
        foreach ($templates as $template)
        {
            $data[$template->Id] = $template->Title;
        }
        return $data;
    }

    public function getOfferPath()
    {
        return \Yii::getPathOfAlias('webroot.docs.offers');
    }

    public function getOfferData()
    {
        $data = $this->getData($this->getOfferPath(), true);
        unset($data['base']);
        return $data;
    }

    private function getData($path, $showExtension = false)
    {
        $data = ['' => \Yii::t('app', 'По умолчанию')];
        foreach (new \DirectoryIterator($path) as $file)
        {
            if ($file->isFile())
            {
                $name = $showExtension ? $file->getBasename() : $file->getBasename('.'.$file->getExtension());
                $data[$name] = $name;
            }
        }
        return $data;
    }
}
