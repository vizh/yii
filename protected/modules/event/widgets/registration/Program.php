<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 24.07.2015
 * Time: 16:49
 */

namespace event\widgets\registration;

use event\models\section\Section;
use event\widgets\ProgramGrid;
use pay\components\managers\Section as SectionProductManager;
use pay\models\OrderItem;
use pay\models\Product;

/**
 * Class Program
 * @package event\widgets\registration
 *
 * @property int $WidgetRegistrationProgramOneOnLineMode
 * @property string $WidgetRegistrationProgramBeforeText
 * @property int $WidgetRegistrationProgramHideForGuest
 * @property int $WidgetRegistrationProgramShowPrice
 */
class Program extends ProgramGrid
{
    /**
     * @inheritdoc
     */
    public function getAttributeNames()
    {
        return [
            'WidgetRegistrationProgramOneOnLineMode',
            'WidgetRegistrationProgramBeforeText',
            'WidgetRegistrationProgramHideForGuest',
            'WidgetRegistrationProgramShowPrice'
        ];
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return 'Программа';
    }

    /**
     * @inheritdoc
     */
    public function getTitleAdmin()
    {
        return 'Регистрация в программе';
    }

    /**
     *
     */
    public function run()
    {
        $this->getProductData();
        $this->render('program', ['grid' => $this->getGrid()]);
    }

    /**
     * Возращает ID товара для секции
     * @param Section $section
     * @return Product|null
     */
    public function getProduct(Section $section)
    {
        if (isset($this->getProductData()[$section->Id])) {
            return $this->getProductData()[$section->Id];
        }
        return null;
    }

    /**
     * Возращает ID заказа для секции
     * @param Section $section
     * @return OrderItem
     */
    public function getOrderItem(Section $section)
    {
        if (isset($this->getOrderItemData()[$section->Id])) {
            return $this->getOrderItemData()[$section->Id];
        }
        return null;
    }

    private $productData = null;

    /**
     * Возвращает массив ввида ID секции => ID товара
     * @return Product[]
     */
    private function getProductData()
    {
        if ($this->productData === null) {
            $this->productData = [];
            $products = Product::model()->byManagerName('Section')->byEventId($this->getEvent()->Id)->byPublic(true)->byDeleted(false)->findAll();
            foreach ($products as $product) {
                /** @var SectionProductManager $manager */
                $manager = $product->getManager();
                $this->productData[$manager->SectionId] = $product;
            }
        }
        return $this->productData;
    }

    private $orderItemData = null;

    /**
     * Возвращает массив ввида ID секции => OrderItem
     * @return OrderItem[]
     */
    private function getOrderItemData()
    {
        if ($this->orderItemData === null) {
            $this->orderItemData = [];
            $user = $this->getUser();
            if ($user !== null) {
                $criteria = new \CDbCriteria();
                $criteria->addInCondition('"t"."ProductId"', \CHtml::listData($this->getProductData(), 'Id', 'Id'));
                $orderItems = OrderItem::model()->byDeleted(false)->byPayerId($user->Id)->byAnyOwnerId($user->Id)->findAll($criteria);
                foreach ($orderItems as $orderItem) {
                    /** @var SectionProductManager $manager */
                    $manager = $orderItem->Product->getManager();
                    $this->orderItemData[$manager->SectionId] = $orderItem;
                }
            }
        }
        return $this->orderItemData;
    }

    /**
     * @inheritdoc
     */
    protected function registerDefaultResources()
    {
        \Yii::app()->getClientScript()->registerPackage('jquery.pin');
        parent::registerDefaultResources();
    }

    /**
     * @return bool
     */
    public function getIsActive()
    {
        if ($this->getUser() === null && isset($this->WidgetRegistrationProgramHideForGuest) && $this->WidgetRegistrationProgramHideForGuest == 1) {
            return false;
        }
        return true;
    }

}