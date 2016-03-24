<?php

namespace widget\models\forms;

use application\components\form\EventItemCreateUpdateForm;
use application\components\helpers\ArrayHelper;
use pay\components\collection\Finder;
use pay\models\CouponActivation;
use pay\models\Product;
use pay\models\ProductPrice;
use user\models\User;

class ProductCount extends EventItemCreateUpdateForm
{
    const SESSION_NAME = 'PRODUCT_COUNT';

    public $Count = [];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['Count', 'validateCount']
        ];
    }

    /**
     * @param $attribute
     * @return bool
     */
    public function validateCount($attribute)
    {
        $valid = true;
        $value = $this->$attribute;
        if (is_array($value)) {
            foreach ($value as $val) {
                if (!is_numeric($val)) {
                    $valid = false;
                }
            }
        } else {
            $valid = false;
        }

        if (!$valid) {
            $this->addError($attribute, \Yii::t('app', 'Неверное значение количества для товаров'));
            return false;
        }
        return true;
    }


    /**
     * @return string
     */
    public function getProductsJson()
    {
        $criteria = new \CDbCriteria();
        $criteria->addCondition('"t"."ManagerName" != \'Ticket\'');

        $products = Product::model()
            ->byEventId($this->event->Id)
            ->byPublic(true)
            ->orderBy(['"t"."Priority"' => SORT_DESC, '"t"."Id"' => SORT_ASC])
            ->findAll();

        $result = [];
        foreach ($products as $product) {
            $item = ArrayHelper::toArray($product, ['pay\models\Product' => ['Id', 'Title', 'Price', 'Description']]);
            $item['count'] = 0;
            $item['participants'] = [];
            $item['priority'] = $product->Priority;
            $this->fillProductFuturePrices($product, $item);
            $result[$product->Id] = $item;
        }
        $this->fillProductsJsonParticipantsData($result);
        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    /**
     * @param $result
     */
    private function fillProductsJsonParticipantsData(&$result)
    {
        /** @var User $user */
        $user = \YIi::app()->getController()->getUser();
        if ($user !== null) {
            $finder = Finder::create($this->event->Id, $user->Id);
            foreach ($finder->getUnpaidFreeCollection() as $collectionItem) {
                $orderItem = $collectionItem->getOrderItem();
                $owner = $orderItem->Owner;
                $participant['RunetId'] = $owner->RunetId;
                $participant['FullName'] = $owner->getFullName();
                $participant['discount'] = $collectionItem->getDiscount();
                $participant['orderItemId'] = $orderItem->Id;
                $participant['price'] = $collectionItem->getPriceDiscount();

                $result[$collectionItem->getOrderItem()->ProductId]['participants'][] = $participant;
            }
        }

        $this->unpack();
        foreach ($this->Count as $id => $count) {
            if ($count > 0 && ($count - sizeof($result[$id]['participants'])) > 0) {
                $result[$id]['participants'] = array_pad($result[$id]['participants'], $count, []);
            }
        }
    }

    /**
     * @param Product $product
     * @param $item
     */
    private function fillProductFuturePrices(Product $product, &$item)
    {
        if (sizeof ($product->PricesActive) > 1) {
            foreach ($product->PricesActive as $i => $price) {
                if ($i == 0) {
                    continue;
                }

                $item['futurePrices'][] = ArrayHelper::toArray($price, [
                    'pay\models\ProductPrice' => [
                        'Price',
                        'Title' => function (ProductPrice $price) {
                            $title = $price->Title;
                            if (empty($title)) {
                                $title = \Yii::t('app', 'с') . ' ' . \Yii::app()->getDateFormatter()->format('d MMMM', $price->StartTime);
                            }
                            return $title;
                        }
                    ]
                ]);
            }
        }
    }

    /**
     * Упаковывает форму в сессию для ее дальнейшей передачи
     */
    public function pack()
    {
        \Yii::app()->getSession()->add(self::SESSION_NAME, $this->getAttributes());
    }

    public function unpack()
    {
        return $this->setAttributes(
            \Yii::app()->getSession()->get(self::SESSION_NAME)
        );
    }

    public function clear()
    {
        \Yii::app()->getSession()->remove(self::SESSION_NAME);
    }
}