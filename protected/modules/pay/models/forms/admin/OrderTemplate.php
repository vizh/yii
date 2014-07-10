<?php
namespace pay\models\forms\admin;

class OrderTemplate extends \CFormModel
{
  const ChildScenario = 'Child';

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
  public $NumberFormat;
  public $Number = 1;

  public $Stamp;
  public $StampMarginLeft;
  public $StampMarginTop;

  public $OfferText;
  
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
      'NumberFormat' => \Yii::t('app', 'Формат номер счета'),
      'Number' => \Yii::t('app', 'Начальный номер счета'),
      'OfferText' => \Yii::t('app', 'Текст оферты'),
        
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
      ['Title', 'required'],
      ['NumberFormat, OfferText', 'safe'],
      ['Number', 'numerical'],
      ['Recipient,Address,Phone,Bank,INN,BIK,AccountNumber,BankAccountNumber', 'required', 'except' => self::ChildScenario],
      ['SignFirstImage,Stamp,SignSecondImage', 'file', 'types' => 'png', 'allowEmpty' => true, 'except' => self::ChildScenario],
      ['KPP,Fax,SignSecondTitle,SignSecondName,SignFirstTitle,SignFirstName', 'safe', 'except' => self::ChildScenario],
      ['VAT', 'boolean', 'except' => self::ChildScenario],
      ['SignFirstImageMarginLeft,SignFirstImageMarginTop,SignSecondImageMarginLeft,SignSecondImageMarginTop,StampMarginLeft,StampMarginTop', 'numerical', 'allowEmpty' => true, 'except' => self::ChildScenario],
      ['SignFirstImageMarginLeft,SignFirstImageMarginTop,SignSecondImageMarginLeft,SignSecondImageMarginTop,StampMarginLeft,StampMarginTop', 'default', 'value' => 0, 'setOnEmpty' => true, 'except' => self::ChildScenario]
    ];
  }
}
