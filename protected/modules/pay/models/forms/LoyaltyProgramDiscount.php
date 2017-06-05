<?php
namespace pay\models\forms;

use application\components\form\CreateUpdateForm;
use event\models\Event;
use pay\models\LoyaltyProgramDiscount as LoyaltyProgramDiscountModel;

class LoyaltyProgramDiscount extends CreateUpdateForm
{
    public $ProductId;

    public $Discount;

    public $StartDate;

    public $EndDate;

    /** @var Event */
    private $event;

    /**
     * @param Event $event
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
        parent::__construct();
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['Discount', 'required'],
            ['ProductId', 'exist', 'className' => '\pay\models\Product', 'attributeName' => 'Id', 'criteria' => ['condition' => '"t"."EventId" = :EventId', 'params' => ['EventId' => $this->event->Id]], 'allowEmpty' => true],
            ['Discount', 'numerical', 'min' => 1, 'max' => 100, 'integerOnly' => true],
            ['StartDate, EndDate', 'date', 'format' => 'dd.MM.yyyy', 'allowEmpty' => true],
            ['StartDate', 'validateDate']
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'Discount' => \Yii::t('app', 'Размер скидки'),
            'ProductId' => \Yii::t('app', 'Товар'),
            'StartDate' => \Yii::t('app', 'Дата начала'),
            'EndDate' => \Yii::t('app', 'Дата окончания')
        ];
    }

    public function validateDate($attribute)
    {
        if (!$this->hasErrors('StartDate') && !$this->hasErrors('EndDate')) {
            $criteria = new \CDbCriteria();
            $criteria->addCondition('"t"."EventId" = :EventId');
            $criteria->params['EventId'] = $this->event->Id;
            if (!empty($this->ProductId)) {
                $criteria->addCondition('"t"."ProductId" IS NULL OR "t"."ProductId" = :ProductId');
                $criteria->params['ProductId'] = $this->ProductId;
            }

            $starttime = !empty($this->StartDate) ? \Yii::app()->getDateFormatter()->format('yyyy-MM-dd 00:00:00', $this->StartDate) : null;
            $endtime = !empty($this->EndDate) ? \Yii::app()->getDateFormatter()->format('yyyy-MM-dd 23:59:59', $this->EndDate) : null;

            if ($starttime !== null && $endtime !== null && $endtime < $starttime) {
                $this->addError('EndDate', \Yii::t('app', 'Дата окончания должна быть больше даты начала.'));
                return false;
            }

            if ($starttime !== null || $endtime !== null) {
                $criteria->addCondition(
                    '(("t"."StartTime" IS NULL OR "t"."StartTime" <= :Time1) AND ("t"."EndTime" IS NULL OR "t"."EndTime" >= :Time2)) OR ("t"."StartTime" >= :Time1 AND "t"."EndTime" <= :Time2)'
                );
                $criteria->params['Time1'] = $starttime !== null ? $starttime : $endtime;
                $criteria->params['Time2'] = $endtime !== null ? $endtime : $starttime;
            }

            if (LoyaltyProgramDiscountModel::model()->exists($criteria)) {
                $this->addError('StartDate', \Yii::t('app', 'Даты действия скидки пересекается с другими скидками.'));
                return false;
            }
        }
        return true;
    }

    /**
     * @return array
     */
    public function getProductData()
    {
        $data = ['' => \Yii::t('app', 'Все продукты')];
        $products = \pay\models\Product::model()->byEventId($this->event->Id)->byPublic(true)->findAll();
        foreach ($products as $product) {
            $data[$product->Id] = $product->Title;
        }
        return $data;
    }

    /**
     * @return null|LoyaltyProgramDiscountModel
     */
    public function createActiveRecord()
    {
        if (!$this->validate()) {
            return null;
        }

        $formatter = \Yii::app()->getDateFormatter();

        $model = new LoyaltyProgramDiscountModel();
        $model->EventId = $this->event->Id;

        $model->Discount = $this->Discount;
        $model->StartTime = !empty($this->StartDate) ? $formatter->format('yyyy-MM-dd 00:00:00', $this->StartDate) : null;
        $model->EndTime = !empty($this->EndDate) ? $formatter->format('yyyy-MM-dd 23:59:59', $this->EndDate) : null;;
        $model->ProductId = !empty($this->ProductId) ? $this->ProductId : null;

        $model->save();
        return $model;
    }

}