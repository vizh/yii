<?php
namespace partner\models\forms\coupon;

use application\components\form\CreateUpdateForm;
use application\helpers\Flash;
use event\models\Event;
use pay\models\Coupon;
use pay\models\Product;

class Generate extends CreateUpdateForm
{
    public $IsMultiple = false;

    public $Count;

    public $Discount;

    public $Products;

    public $ProductsAll = true;

    public $EndTime;

    public $Code;

    /** @var Event */
    private $event;

    /**
     * @param Event $event
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
        parent::__construct(null);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['IsMultiple', 'boolean'],
            ['Code', 'match', 'pattern' => '/^[A-Za-z0-9_\-]+$/', 'allowEmpty' => true, 'message' => 'Поле "Промо-код" может содержать только латиницу, цифры, знаки "_" и "-"'],
            ['Code', 'validateCode'],
            ['Count', 'numerical', 'min' => 1, 'integerOnly' => true, 'allowEmpty' => false],
            ['Discount', 'numerical', 'min' => 1, 'max' => 100, 'integerOnly' => true, 'allowEmpty' => false],
            ['Discount', 'validateDiscount'],
            ['EndTime', 'date', 'allowEmpty' => true, 'format' => 'dd.MM.yyyy'],
            ['ProductsAll', 'boolean'],
            ['Products', 'validateProducts']
        ];
    }

    /**
     * @param $attribute
     * @return bool
     */
    public function validateCode($attribute)
    {
        $value = $this->$attribute;
        if ($this->IsMultiple == 1) {
            if (empty($value)) {
                $this->addError($attribute, \Yii::t('app', 'Необходимо заполнить поле {label}.', ['{label}' => $this->getAttributeLabel($attribute)]));
                return false;
            }

            $exists = Coupon::model()->byEventId($this->event->Id)->byCode($value)->byDeleted(false)->exists();
            if ($exists) {
                $this->addError($attribute, \Yii::t('app', 'Такой промо-код уже существует.'));
                return false;
            }
        }
        return true;
    }

    /**
     * @param $attribute
     * @return bool
     */
    public function validateDiscount($attribute)
    {
        $value = (int)$this->$attribute;
        if ($value === 100 && empty($this->Products)) {
            $this->addError($attribute, \Yii::t('app', 'Для промо-кодов со скидкой 100% должен быть {label}.', ['{label}' => $this->getAttributeLabel('Products')]));
            return false;
        }
        return true;
    }

    public function validateProducts($attribute)
    {
        $products = $this->$attribute;
        $valid = true;
        if (!empty($products)) {
            if (is_array($products)) {
                foreach (array_keys($products) as $id) {
                    $product = Product::model()->byEventId($this->event->Id)->findByPk($id);
                    if (empty($product)) {
                        $valid = false;
                    }
                }
            } else {
                $valid = false;
            }
        }

        if (!$valid) {
            $this->addError($attribute, \Yii::t('app', 'Тип продукта отсутствует в списке.'));
        }
    }

    /**
     * @inheritdoc
     */
    public function createActiveRecord()
    {
        if (!$this->validate()) {
            return null;
        }

        $transaction = \Yii::app()->getDb()->beginTransaction();
        try {
            $coupons = [];
            if ($this->IsMultiple) {
                $coupon = new Coupon();
                $coupon->Multiple = true;
                $coupon->MultipleCount = $this->Count;
                $this->fillAndSaveModel($coupon);
                $coupons[] = $coupon;
            } else {
                for ($i = 0; $i < $this->Count; $i++) {
                    $coupon = new Coupon();
                    $this->fillAndSaveModel($coupon);
                    $coupons[] = $coupon;
                }
            }
            $transaction->commit();
            return $coupons;
        } catch (\CDbException $e) {
            $transaction->rollBack();
            Flash::setError($e);
        }
        return null;
    }

    /**
     * @param Coupon $coupon
     */
    private function fillAndSaveModel(Coupon $coupon)
    {
        $coupon->EventId = $this->event->Id;
        $coupon->Discount = $this->Discount;
        $coupon->Code = !empty($this->Code) && $this->IsMultiple == 1 ? $this->Code : $coupon->generateCode();
        if (!empty($this->EndTime)) {
            $coupon->EndTime = date('Y-m-d', strtotime($this->EndTime)).' 23:59:59';
        }
        $coupon->save();
        if (!empty($this->Products)) {
            $products = Product::model()->findAllByPk(array_keys($this->Products));
            $coupon->addProductLinks($products);
        }
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        $labels = [
            'Code' => 'Код',
            'CountCoupons' => 'Кол-во кодов',
            'Discount' => 'Размер скидки (%)',
            'Products' => 'Тип продукта',
            'EndTime' => 'Срок действия до',
            'CountActivations' => 'Кол-во активаций'
        ];

        $labels['Count'] = $this->IsMultiple == 1 ? $labels['CountActivations'] : $labels['CountCoupons'];
        return $labels;
    }

    /**
     * @return array
     */
    public function getProductData()
    {
        $criteria = new \CDbCriteria();
        $criteria->addCondition('"t"."ManagerName" != :ManagerName');
        $criteria->params['ManagerName'] = 'RoomProductManager';
        $products = Product::model()->byEventId($this->event->Id)->byDeleted(false)->findAll($criteria);
        return \CHtml::listData($products, 'Id', 'Title');
    }
}
