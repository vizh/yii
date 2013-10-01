<?php
namespace pay\models\forms\admin;

class OrderTemplate extends \CFormModel
{
  public $Title;
  public $Recipient;
  public $Address;
  public $INN;
  public $KPP;
  public $Bank;
  public $BankAccountNumber;
  public $AccountNumber;
  public $BIK;
  public $Phone;
  public $Fax;
  public $VAT = true;

  public $Stamp;
  public $StampMarginLeft;
  public $StampMarginTop;
  
  public $SignFirstTitle;
  public $SignFirstName;
  public $SignFirstImage;
  public $SignFirstImageMarginLeft;
  public $SignFirstImageMarginTop;
  
  public $SignSecondTitle;
  public $SignSecondName;
  public $SignSecondImage;
  public $SignSecondImageMarginLeft;
  public $SignSecondImageMarginTop;
  
  public function attributeLabels()
  {
    return [
      'Title' => \Yii::t('app', 'Название шаблона'),
      'Recipient' => \Yii::t('app', 'Получатель'),
      'VAT' => \Yii::t('app', 'Облагается НДС?'),
      'Address'  => \Yii::t('app', 'Адрес'),
      'INN' => \Yii::t('app', 'ИНН'),
      'KPP' => \Yii::t('app', 'КПП'),
      'Bank' => \Yii::t('app', 'Банк'),
      'BankAccountNumber' => \Yii::t('app', 'Кор. номер счета'),
      'AccountNumber' => \Yii::t('app', 'Номер счета'),
      'BIK' => \Yii::t('app', 'БИК'),
      'Phone' => \Yii::t('app', 'Телефон'),
      'Fax' => \Yii::t('app', 'Факс'),
        
      'SignFirstTitle' => \Yii::t('app', 'Заголовок подписи'),
      'SignFirstName'  => \Yii::t('app', 'Имя около подписи'),
      'SignFirstImage' => \Yii::t('app', 'Изображение с подписью'),  
      'SignFirstImageMarginLeft' => \Yii::t('app', 'Смещение изображения подписи слева'),
      'SignFirstImageMarginTop'  => \Yii::t('app', 'Смещение изображения подписи сверху'),
        
      'SignSecondTitle' => \Yii::t('app', 'Заголовок подписи'),
      'SignSecondName'  => \Yii::t('app', 'Имя около подписи'),
      'SignSecondImage' => \Yii::t('app', 'Изображение с подписью'),
      'SignSecondImageMarginLeft' => \Yii::t('app', 'Смещение изображения подписи слева'),
      'SignSecondImageMarginTop'  => \Yii::t('app', 'Смещение изображения подписи сверху'),
        
      'Stamp' => \Yii::t('app', 'Изображение печати'),
      'StampMarginLeft' => \Yii::t('app', 'Смещение изображения печати слева'),
      'StampMarginTop' => \Yii::t('app', 'Смещение изображения печати сверху')
    ];
  }
  
  public function rules()
  {
    return [
      ['Title,Recipient,Address,Phone,Bank,INN,BIK,AccountNumber,SignFirstTitle,SignFirstName,BankAccountNumber', 'required'],
      ['SignFirstImage,Stamp,SignSecondImage', 'file', 'types' => 'png', 'allowEmpty' => true],
      ['KPP,Fax,SignSecondTitle,SignSecondName', 'safe'],
      ['VAT', 'boolean'],
      ['SignFirstImageMarginLeft,SignFirstImageMarginTop,SignSecondImageMarginLeft,SignSecondImageMarginTop,StampMarginLeft,StampMarginTop', 'numerical', 'allowEmpty' => true],
      ['SignFirstImageMarginLeft,SignFirstImageMarginTop,SignSecondImageMarginLeft,SignSecondImageMarginTop,StampMarginLeft,StampMarginTop', 'default', 'value' => 0, 'setOnEmpty' => true]
    ];
  }
}
