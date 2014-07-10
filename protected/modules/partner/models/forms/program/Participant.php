<?php
namespace partner\models\forms\program;

class Participant extends \CFormModel
{
  public $Id;

  public $RoleId;
  public $ReportTitle;
  public $ReportThesis;
  public $ReportUrl;
  public $ReportFullInfo;
  public $VideoUrl;
  public $Delete;
  public $Order;

  public $RunetId;
  public $CompanyId;
  public $CustomText;

  /**
   * @param \event\models\section\LinkUser $linkUser
   * @param string $scenario
   */
  public function __construct($linkUser = null, $scenario = '')
  {
    parent::__construct($scenario);

    if ($linkUser !== null)
    {
      $this->Id = $linkUser->Id;
      $this->RunetId = $linkUser->UserId !== null ? $linkUser->User->RunetId : null;
      $this->CompanyId = $linkUser->CompanyId;
      $this->CustomText = $linkUser->CustomText;
      $this->RoleId = $linkUser->RoleId;
      $this->Order = $linkUser->Order;
      $this->VideoUrl = $linkUser->VideoUrl;
      if ($linkUser->Report !== null)
      {
        $this->ReportTitle = $linkUser->Report->Title;
        $this->ReportThesis = $linkUser->Report->Thesis;
        $this->ReportUrl = $linkUser->Report->Url;
        $this->ReportFullInfo = $linkUser->Report->FullInfo;
      }
    }
  }

  protected function beforeValidate()
  {
    $this->CustomText = trim($this->CustomText);
    if (empty($this->RunetId) && empty($this->CompanyId) && empty($this->CustomText))
    {
      $this->addError('', 'Должно быть заполнено хотя бы одно из полей: RUNET-ID, ID компании или Произвольный текст');
    }
    return parent::beforeValidate();
  }


  public function rules()
  {
    return [
      ['Id, Order', 'numerical', 'allowEmpty' => true],
      ['RoleId', 'required'],
      ['RunetId, CompanyId, CustomText, ReportTitle, ReportThesis, Delete, ReportFullInfo, VideoUrl', 'safe'],
      ['ReportUrl', 'url', 'allowEmpty' => true],
      ['ReportFullInfo', 'filter', 'filter' => [$this, 'filterReportFullInfo']]
    ];
  }

  public function filterReportFullInfo($value)
  {
    $purifier = new \CHtmlPurifier();
    $purifier->options = [
      'HTML.AllowedElements'     => ['p', 'span', 'ol', 'li', 'strong', 'a', 'em', 's', 'ul', 'br', 'u', 'table', 'tbody', 'tr', 'td', 'thead', 'th', 'caption', 'h1', 'h2', 'h3', 'h4', 'h5', 'img'],
      'HTML.AllowedAttributes'   => ['style', 'a.href', 'a.target', 'table.cellpadding', 'table.cellspacing', 'th.scope', 'table.border', 'img.alt', 'img.src'],
      'Attr.AllowedFrameTargets' => ['_blank', '_self']
    ];
    return $purifier->purify($value);
  }

  public function attributeLabels()
  {
    return [
      'RunetId' => \Yii::t('app', 'RUNET-ID'),
      'CompanyId' => \Yii::t('app', 'ID компании'),
      'CustomText' => \Yii::t('app', 'Произвольный текст'),
      'RoleId' => \Yii::t('app', 'ID роли'),
      'ReportTitle' => \Yii::t('app', 'Название доклада'),
      'ReportThesis' => \Yii::t('app', 'Тезисы доклада'),
      'ReportFullInfo' => \Yii::t('app', 'Текст доклада'),
      'ReportUrl' => \Yii::t('app', 'Url доклада'),
      'Delete' => \Yii::t('app', 'Удалить'),
      'Order' => \Yii::t('app', 'Сортировка'),
      'Role' => \Yii::t('app', 'Роль'),
      'Report' => \Yii::t('app', 'Доклад'),
      'VideoUrl' => \Yii::t('app', 'Ссылка на видеозапись')
    ];
  }

  /** @var \user\models\User */
  public $user = null;

  /** @var \company\models\Company */
  public $company = null;

  public function buildModels()
  {
    if (!empty($this->RunetId))
    {
      $this->user = \user\models\User::model()->byRunetId($this->RunetId)->find();
      if ($this->user === null)
      {
        $this->addError('', \Yii::t('app', 'Не найден пользователь с RUNET-ID: {RunetId}', array('RunetId' => $this->RunetId)));
      }
      return;
    }

    if (!empty($this->CompanyId))
    {
      $this->company = \company\models\Company::model()->findByPk($this->CompanyId);
      if ($this->company === null)
      {
        $this->addError('', \Yii::t('app', 'Не найдена компания с ID: {CompanyId}', array('CompanyId' => $this->CompanyId)));
      }
      return;
    }
  }

  public function getIsEmptyReportData()
  {
    return empty($this->ReportTitle) && empty($this->ReportThesis) && empty($this->ReportUrl) && empty($this->ReportFullInfo);
  }
}
