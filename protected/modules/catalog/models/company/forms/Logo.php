<?php
namespace catalog\models\company\forms;

class Logo extends \CFormModel
{
    public $Id;

    public $Raster;
    public $Vector;
    public $W100px;

    public $Delete;

    protected $logo;

    public function __construct($logo = null, $scenario = '')
    {
        parent::__construct($scenario);
        if ($logo !== null) {
            $this->logo = $logo;
            $this->Id = $logo->getId();
        }
    }

    public function rules()
    {
        return [
            ['Id,Delete', 'numerical', 'allowEmpty' => true],
            ['Raster, W100px', 'file', 'types' => 'jpg, gif, png', 'allowEmpty' => true],
            ['Vector', 'file', 'types' => 'ai, eps', 'allowEmpty' => true],
            ['Raster', 'filter', 'filter' => [$this, 'filterLogoFields']]
        ];
    }

    public function filterLogoFields($value)
    {
        if (empty($this->Delete)) {
            if ($this->Raster == null && $this->Vector == null) {
                $this->addError('Raster', \Yii::t('app', 'Выберите логотип'));
            }
        }
        return $value;
    }

    public function getLogo()
    {
        return $this->logo;
    }

    public function attributeLabels()
    {
        return [
            'Raster' => \Yii::t('app', 'Логотип в растре'),
            'Vector' => \Yii::t('app', 'Логотип в векторе'),
            'W100px' => \Yii::t('app', 'Превью (ширина: 100px)')
        ];
    }

    /**
     *
     */
    public function beforeValidate()
    {
        $this->Raster = \CUploadedFile::getInstance($this, 'Raster');
        $this->Vector = \CUploadedFile::getInstance($this, 'Vector');
        $this->W100px = \CUploadedFile::getInstance($this, 'W100px');
        return parent::beforeValidate();
    }
}
