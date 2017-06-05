<?php
namespace partner\models\forms\coupon;

use application\components\form\CreateUpdateForm;
use application\helpers\Flash;
use pay\models\Coupon;

class Give extends CreateUpdateForm
{
    /** @var Coupon[] */
    public $coupons = [];

    public $Recipient;

    /**
     * @param Coupon[] $coupons
     */
    public function __construct($coupons)
    {
        $this->coupons = $coupons;
        parent::__construct(null);
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'Recipient' => \Yii::t('app', 'Кому выдать купон')
        ];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['Recipient', 'filter', 'filter' => '\application\components\utility\Texts::clear'],
            ['Recipient', 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function updateActiveRecord()
    {
        if (!$this->validate()) {
            return null;
        }

        $transaction = \Yii::app()->getDb()->beginTransaction();
        try {
            $formatter = \Yii::app()->getDateFormatter();
            foreach ($this->getCoupons() as $coupon) {
                $coupon->Recipient = $formatter->format('dd MMMM yyyy', time()).': '.$this->Recipient.'; '.$coupon->Recipient;
                $coupon->save();
            }
            $transaction->commit();
            return $this->getCoupons();
        } catch (\CDbException $e) {
            $transaction->rollBack();
            Flash::setError($e);
        }
        return null;
    }

    /**
     * @return \pay\models\Coupon[]
     */
    public function getCoupons()
    {
        return $this->coupons;
    }
}
