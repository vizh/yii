<?php
namespace competence\models\form\event;

use application\components\auth\identity\RunetId;
use application\components\form\FormModel;
use application\modules\competence\components\EventCode;
use competence\models\Test;

class CodeValidation extends FormModel
{
    private $test;

    public $Code;

    public function __construct(Test $test, $scenario = '')
    {
        parent::__construct($scenario);
        $this->test = $test;
    }

    public function attributeLabels()
    {
        return [
            'Code' => \Yii::t('app', 'Код участника')
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['Code', 'required'],
            ['Code', 'validateCode', 'skipOnError' => true]
        ];
    }

    /**
     * Валидация кода участника
     * @param string $attribute
     */
    public function validateCode($attribute)
    {
        $code = $this->$attribute;
        if ($this->getUser($code) === null) {
            $this->addError($attribute, \Yii::t('app', 'Указан неверный код участника.'));
        }
    }

    private $user = false;

    /**
     * @param $code
     * @return null|\user\models\User
     */
    private function getUser($code)
    {
        if ($this->user === false) {
            $this->user = EventCode::parse($code, $this->test);
        }
        return $this->user;
    }

    /**
     * @throws \CException
     */
    public function process()
    {
        if (!$this->validate()) {
            return false;
        }

        $identity = new RunetId($this->getUser($this->Code)->RunetId);
        $identity->authenticate();
        if ($identity->errorCode == \CUserIdentity::ERROR_NONE) {
            \Yii::app()->user->login($identity);
        }
        return true;
    }
}