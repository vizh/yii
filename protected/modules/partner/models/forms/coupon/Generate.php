<?php
namespace partner\models\forms\coupon;

use pay\models\Coupon;
use pay\models\CouponLinkProduct;
use pay\models\Product;

class Generate extends \CFormModel
{
    public $type = 'solo';
    public $count;
    public $discount;
    public $productIdList = [0];
    public $endTime;

    public $code;

    /** @var \pay\models\Product[] */
    public $productList;

    /** @var \event\models\Event */
    public $event = null;

    public function rules()
    {
        return [
            ['type, productIdList, code', 'safe'],
            ['discount', 'numerical', 'min' => 1, 'max' => 100, 'integerOnly' => true, 'allowEmpty' => false],
            ['count', 'numerical', 'min' => 1, 'integerOnly' => true, 'allowEmpty' => false],
            ['endTime', 'date', 'allowEmpty' => true, 'format' => 'dd.MM.yyyy'],

            /** Валидация для сценария many */
            ['code', 'match', 'pattern' => '/^[A-Za-z0-9_\-]+$/', 'allowEmpty' => false, 'on' => 'many', 'message' => 'Поле "Промо-код" может содержать только латиницу, цифры, знаки "_" и "-"'],
        ];
    }

    public function getTypes()
    {
        return [
            'solo' => 'Индивидуальный',
            'many' => 'Множественный',
        ];
    }

    protected function afterValidate()
    {
        parent::afterValidate();
        $this->discount = (int)$this->discount;

        $this->productList = [];
        foreach ($this->productIdList as $productId) {
            if ($productId == 0)
                continue;
            $product = Product::model()->findByPk($productId);
            if ($product === null || $product->EventId != $this->event->Id) {
                $this->addError('productIdList', 'Проблема при назначении типа продукта с ID: ' . $productId);
            } else {
                $this->productList[] = $product;
            }
        }

        if (Coupon::model()->byCode($this->code)->byEventId($this->event->Id)->exists()) {
            $this->addError('code', 'Такой промо-код уже существует.');
        }
    }

    /**
     * @return \pay\models\Coupon[] $coupon
     */
    public function generate()
    {
        $result = [];
        $endTime = !empty($this->endTime) ? date('Y-m-d', strtotime($this->endTime)) . ' 23:59:59' : null;
        if ($this->type == 'many')
        {
            $coupon = new Coupon();
            $coupon->EventId = $this->event->Id;
            $coupon->Discount = (float) $this->discount / 100;
            $coupon->Code = $this->code;
            $coupon->Multiple = true;
            $coupon->MultipleCount = $this->count;
            $coupon->EndTime = $endTime;
            $coupon->save();

            $coupon->addProductLinks($this->productList);


            $result[] = $coupon;
        }
        else
        {
            for ($i=0; $i<$this->count; $i++)
            {
                $coupon = new Coupon();
                $coupon->EventId = $this->event->Id;
                $coupon->Discount = (float) $this->discount / 100;
                $coupon->Code = $coupon->generateCode();
                $coupon->EndTime = $endTime;
                $coupon->save();

                $coupon->addProductLinks($this->productList);

                $result[] = $coupon;
            }
        }

        return $result;
    }


    public function attributeLabels()
    {
        return [
            'code' => 'Промо-код',
            'count' => $this->getCountTitle(),
            'discount' => 'Размер скидки (%)',
            'productIdList' => 'Тип продукта',
            'endTime' => 'Срок действия до'
        ];
    }

    protected function getCountTitle()
    {
        if ($this->scenario == 'many')
        {
            return 'Количество активаций промо-кодa';
        }
        return 'Количество промо-кодов';
    }
}
