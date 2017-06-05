<?php
namespace pay\models\forms;

class ProductPrice extends \CFormModel
{
    const FORMAT_DATEFIELD = 'dd.MM.yyyy';

    public $Id;
    public $ProductId;
    public $Title;
    public $Price;
    public $StartDate;
    public $EndDate;
    public $Delete;

    public function rules()
    {
        return [
            ['ProductId,Price,StartDate', 'required'],
            ['Id,ProductId,Price', 'numerical'],
            ['Id, Delete', 'safe'],
            ['Title', 'filter', 'filter' => [new \application\components\utility\Texts(), 'filterPurify']],
            ['StartDate', 'date', 'format' => self::FORMAT_DATEFIELD, 'allowEmpty' => false],
            ['EndDate', 'date', 'format' => self::FORMAT_DATEFIELD, 'allowEmpty' => true],
            ['StartDate', 'filter', 'filter' => [$this, 'filterDate']]
        ];
    }

    public function filterDate($value)
    {
        if (!empty($this->EndDate)) {
            if (strtotime($this->EndDate) <= strtotime($this->StartDate)) {
                $this->addError('StartDate', \Yii::t('app', 'Дата начала действия цены должна быть меньше даты окончания'));
            }
        }
        return $value;
    }

    public function setAttributes($values, $safeOnly = true)
    {
        if (isset($values['StartTime'])) {
            $this->StartDate = \Yii::app()->getDateFormatter()->format(self::FORMAT_DATEFIELD, $values['StartTime']);
            unset($values['StartTime']);
        }

        if (isset($values['EndTime'])) {
            $this->EndDate = \Yii::app()->getDateFormatter()->format(self::FORMAT_DATEFIELD, $values['EndTime']);
            unset($values['EndTime']);
        }
        parent::setAttributes($values, $safeOnly);
    }

    public function getStartTime()
    {
        return \Yii::app()->getDateFormatter()->format('yyyy-MM-dd', $this->StartDate).' 00:00:00';
    }

    public function getEndTime()
    {
        if (!empty($this->EndDate)) {
            return \Yii::app()->getDateFormatter()->format('yyyy-MM-dd', $this->EndDate).' 23:59:59';
        }
        return null;
    }
}
