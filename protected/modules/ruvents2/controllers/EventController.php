<?php
namespace ruvents2\controllers;

use application\components\helpers\ArrayHelper;
use pay\models\Product;
use ruvents2\components\Controller;
use ruvents2\models\Operator;

class EventController extends Controller
{
    public function actionIndex()
    {
        $result = ArrayHelper::toArray($this->getEvent(), ['event\models\Event' => ['Id', 'IdName', 'Title', 'Description' => 'Info']]);
        $this->renderJson($result);
    }

    public function actionOperators()
    {
        $operators = Operator::model()->byEventId($this->getEvent()->Id)->findAll();
        $result = [];
        foreach ($operators as $operator) {
            $result[] = ArrayHelper::toArray($operator, ['ruvents2\models\Operator' => ['Id', 'Login', 'Password', 'Role']]);
        }
        $this->renderJson(['Operators' => $result]);
    }

    public function actionStatuses()
    {
        $roles = $this->getEvent()->getRoles();
        $result = [];
        foreach ($roles as $role) {
            $result[] = ArrayHelper::toArray($role, ['event\models\Role' => ['Id', 'Title', 'Color', 'Priority']]);
        }
        $this->renderJson(['Statuses' => $result]);
    }

    public function actionParts()
    {
        $result = [];
        foreach ($this->getEvent()->Parts as $part) {
            $result[] = ArrayHelper::toArray($part, ['event\models\Part' => ['Id', 'Title', 'Order']]);
        }
        $this->renderJson(['Parts' => $result]);
    }

    public function actionProducts()
    {
        $products = Product::model()->byEventId($this->getEvent()->Id)->byVisibleForRuvents(true)->findAll();
        $result = [];
        foreach ($products as $product) {
            $result[] = ArrayHelper::toArray($product, ['pay\models\Product' => [
                'Id', 'Manager' => 'ManagerName', 'Title', 'Price' => function ($product) {
                    /** @var Product $product */
                    return $product->getPrice();
                }
            ]]);
        }
        $this->renderJson(['Products' => $result]);
    }
}