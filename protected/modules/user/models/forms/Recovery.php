<?php
namespace user\models\forms;
class Recovery extends \CFormModel
{
    public $EmailOrPhone;
    public $Code;
    public $Captcha;

    public $ShowCode = false;


    public function rules()
    {
        return [
            ['EmailOrPhone', 'required'],
            ['Code', 'safe'],
            ['Captcha', 'captcha', 'allowEmpty' => empty($this->Code)]
        ];
    }

    public function attributeLabels()
    {
        return [
            'EmailOrPhone' => \Yii::t('app', 'Электронная почта или номер телефона'),
            'Captcha' => \Yii::t('app', 'Код проверки')
        ];
    }
}
