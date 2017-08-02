<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 01.09.2015
 * Time: 18:08
 */

namespace oauth\models\forms;

use application\components\auth\identity\RunetId;
use application\components\Exception;
use contact\models\Address;
use contact\models\forms\Address as AddressForm;
use oauth\components\social\Proxy;
use user\models\forms\Register as BaseRegisterForm;
use user\models\Log;



class Register extends BaseRegisterForm
{
    const RECAPTCH_SECRET = '6LerUwgTAAAAANSAzVD3IlpODDgpaH9NgN6gl46h';

    /** @var string */
    private $social;

    public $Subscribe;

    public $Captcha;

    public $AcceptPolicy;

    /** @var AddressForm */
    public $Address;

    /**
     * @inheritdoc
     */
    public function __construct($social)
    {
        $this->social = $social;
        $this->Address = new AddressForm();
        parent::__construct(null);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules[] = ['Phone', 'required'];
        $rules[] = ['Subscribe', 'boolean'];
        $rules[] = ['Captcha', 'validateCaptcha'];
        $rules[] = ['AcceptPolicy', 'compare', 'compareValue' => true, 'message'=>'Дайте согласие на обработку персональных данных'];

        if (\Yii::app()->getRequest()->getParam('apikey') === '3thn47hihr') {
            $rules[] = ['Company', 'required'];
            $rules[] = ['Position', 'required'];
        }

        return $rules;
    }

    /**
     * @inheritdoc
     */
    protected function afterValidate()
    {
        $this->Address->attributes = \Yii::app()->getRequest()->getParam(get_class($this->Address));
        if (!$this->Address->validate()) {
            foreach ($this->Address->getErrors() as $messages) {
                $this->addError('Address', $messages[0]);
            }
        }
        parent::afterValidate();
    }

    /**
     * Валидация каптчи
     */
    public function validateCaptcha()
    {
        $response = \Yii::app()->getRequest()->getPost('g-recaptcha-response');
        if (empty($response)) {
            $this->addError('Captcha', \Yii::t('app', 'Поставьте галочку "Я не робот"'));
        } else {
            $data = http_build_query([
                'secret' => self::RECAPTCH_SECRET,
                'response' => $response
            ]);
            $opts = [
                'http' => [
                    'method' => 'POST',
                    'header' => 'Content-type: application/x-www-form-urlencoded',
                    'content' => $data
                ]
            ];
            $context = stream_context_create($opts);
            $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
            if (!$response) {
                $this->addError('Captcha', \Yii::t('app', 'Нет связи с сервером капчи'));
            } else {
                $result = json_decode($response);
                if (!$result->success) {
                    $this->addError('Captcha', \Yii::t('app', 'Поставьте галочку "Я не робот"'));
                }
            }
        }
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['Subscribe'] = \Yii::t('app', 'Я хочу получать информационные рассылки RUNET-ID');
        $labels['AcceptPolicy'] = \Yii::t('app', 'Я даю согласие на обработку персональных данных');

        return $labels;
    }

    /**
     * @inheritdoc
     */
    public function createActiveRecord()
    {
        $user = parent::createActiveRecord();
        if ($user !== null) {
            $identity = new RunetId($user->RunetId);
            $identity->authenticate();
            if ($identity->errorCode == \CUserIdentity::ERROR_NONE) {
                \Yii::app()->getUser()->login($identity);
                if ($this->getSocialProxyIsHasAccess()) {
                    $this->getSocialProxy()->saveSocialData($user);
                    Log::create($user);
                }
            } else {
                throw new Exception('Не удалось пройти авторизацию после регистрации. Код ошибки: '.$identity->errorCode);
            }
        }
        return $user;
    }

    /**
     * @inheritdoc
     */
    protected function internalCreateActiveRecord()
    {
        parent::internalCreateActiveRecord();
        $this->model->Settings->UnsubscribeAll = !(bool)$this->Subscribe;
        $this->model->Settings->save();

        if (!$this->Address->getIsEmpty()) {
            $address = new Address();
            $address->setAttributes($this->Address->getAttributes(), false);
            $address->save();
            $this->model->setContactAddress($address);
        }
    }

    private $socialProxy = false;

    /**
     * @return null|Proxy
     */
    public function getSocialProxy()
    {
        if ($this->socialProxy === false) {
            $this->socialProxy = !empty($this->social) ? new Proxy($this->social) : null;
        }
        return $this->socialProxy;
    }

    /**
     * @return bool
     */
    public function getSocialProxyIsHasAccess()
    {
        return $this->getSocialProxy() !== null && $this->getSocialProxy()->isHasAccess();
    }

    /**
     * Заполняет данные из аккаунт в соц. сетях если он используется
     * @return bool
     */
    public function fillFromSocialProxy()
    {
        if ($this->getSocialProxyIsHasAccess()) {
            $this->LastName = $this->getSocialProxy()->getData()->LastName;
            $this->FirstName = $this->getSocialProxy()->getData()->FirstName;
            $this->Email = $this->getSocialProxy()->getData()->Email;
            return true;
        }
        return false;
    }
}
