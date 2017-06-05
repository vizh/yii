<?php

namespace pay\models\forms\admin;

use application\components\form\FormModel;
use event\models\Participant;
use pay\models\OrderItem;
use pay\models\Product;
use pay\models\search\admin\booking\FoodNaturalSearch;
use user\models\User;

class FoodNaturalForm extends FormModel
{
    public $User;
    public $ProductIds;

    public $products = [];

    protected $UserModel;

    public function init()
    {
        parent::init();
        foreach (FoodNaturalSearch::$productIds as $date => $meals) {
            foreach ($meals as $meal => $id) {
                if (!isset($this->products[$date])) {
                    $this->products[$date] = [];
                }
                $this->products[$date][$meal] = Product::model()->findByPk($id);
            }
        }
    }

    public function rules()
    {
        return [
            ['User, ProductIds', 'required'],
            ['User', 'validateUser'],
        ];
    }

    public function validateUser()
    {
        $this->UserModel = User::model()->findByAttributes(['RunetId' => $this->User]);
        if (!$this->UserModel) {
            $this->addError('User', 'Пользователь не найден');
            return;
        }
        $participant = Participant::model()->findByAttributes(['EventId' => 3016, 'UserId' => $this->UserModel->Id]);
        if (!$participant) {
            $this->addError('User', 'Пользователь не зарегистрирован на мероприятие');
        }
    }

    public function save()
    {
        foreach ($this->ProductIds as $productId) {
            $item = new OrderItem();
            $item->PayerId = $this->UserModel->Id;
            $item->OwnerId = $this->UserModel->Id;
            $item->ProductId = $productId;
            $item->save();
        }
    }
}