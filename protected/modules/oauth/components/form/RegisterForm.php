<?php
namespace oauth\components\form;

use api\models\Account;
use contact\models\forms\Address;
use user\models\User;

class RegisterForm extends \CFormModel
{
    private $account = null;

    public $LastName;
    public $FirstName;
    public $FatherName;
    public $Email;
    public $CompanyId;
    public $Company;
    public $Address;
    public $Phone;

    public $RecaptchSecret = '6LerUwgTAAAAANSAzVD3IlpODDgpaH9NgN6gl46h';

    public function __construct(Account $account)
    {
        parent::__construct('');
        $this->account = $account;
        $this->Address = new Address();
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'LastName' => \Yii::t('app', 'Фамилия'),
            'FirstName' => \Yii::t('app', 'Имя'),
            'FatherName' => \Yii::t('app', 'Отчество'),
            'Email' => \Yii::t('app', 'Электронная почта'),
            'Company' => \Yii::t('app', 'Компания'),
            'City' => \Yii::t('app', 'Город'),
            'Phone' => \Yii::t('app', 'Номер телефона')
        );
    }

    public function afterValidate()
    {
        $this->Address->attributes = \Yii::app()->getRequest()->getParam(get_class($this->Address));
        if (!$this->Address->validate()) {
            foreach ($this->Address->getErrors() as $messages) {
                $this->addError('Address', $messages[0]);
            }
        }
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['Phone', 'filter', 'filter' => '\application\components\utility\Texts::getOnlyNumbers'],
            ['FirstName, LastName, Email, Phone', 'required'],
            ['Email', 'email'],
            ['Email', 'uniqueEmailValidate'],
            ['FatherName, CompanyId, Company', 'safe'],
            ['Phone', 'unique', 'className' => '\user\models\User', 'attributeName' => 'PrimaryPhone', 'criteria' => ['condition' => '"t"."Visible"']]
        ];
    }

    public function uniqueEmailValidate($attribute, $params)
    {
        $value = trim($this->$attribute);
        if (!empty($value)) {
            if (!User::model()->byEmail($value)->byVisible(true)->exists()) {
                return true;
            }
            $this->addError($attribute, 'Пользователь с таким Email уже существует.');
        }
        return false;
    }

    protected function beforeValidate()
    {
        $response = \Yii::app()->request->getPost('g-recaptcha-response');
        if ($response == ''){
            $this->addError('Captcha', \Yii::t('app', 'Поставьте галочку "Я не робот"'));
        } else {
            $postdata = http_build_query(
                [
                    'secret' => $this->RecaptchSecret,
                    'response' => $response
                ]
            );
            $opts = ['http' =>
                [
                    'method' => 'POST',
                    'header' => 'Content-type: application/x-www-form-urlencoded',
                    'content' => $postdata
                ]
            ];
            $context = stream_context_create($opts);
            $captchaResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
            if (!$captchaResponse) {
                $this->addError('Captcha', \Yii::t('app', 'Нет связи с сервером капчи'));
            } else {
                $result = json_decode($captchaResponse);
                if (!$result->success) {
                    $this->addError('Captcha', \Yii::t('app', 'Поставьте галочку "Я не робот"'));
                }
            }
        }
        $purifier = new \CHtmlPurifier();
        $purifier->options = array(
            'HTML.AllowedElements' => array()
        );
        $attributes = $this->attributes;
        foreach ($this->attributes as $field => $value) {
            if ($field == 'Address' || $field == 'Phone')
                continue;
            $attributes[$field] = $purifier->purify($value);
        }
        $this->attributes = $attributes;
        return parent::beforeValidate();
    }

    /**
     * @return \api\models\Account|null
     */
    public function getAccount()
    {
        return $this->account;
    }
}
