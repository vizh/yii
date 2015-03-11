<?php
namespace partner\widgets;

class TopMenu extends \CWidget
{

    public function run()
    {
        $menu = [];
        $menu[] = [
            'Title' => 'Главная',
            'Url' => \Yii::app()->createUrl('/partner/main/index'),
            'Access' => $this->checkAccess('main', 'index'),
            'Active' => $this->isActive('main')
        ];
        $menu[] = [
            'Title' => 'Регистрации',
            'Url' => \Yii::app()->createUrl('/partner/ruvents/index'),
            'Access' => $this->checkAccess('ruvents', 'index'),
            'Active' => $this->isActive('ruvents')
        ];
        $menu[] = [
            'Title' => 'Участники',
            'Url' => \Yii::app()->createUrl('/partner/user/index'),
            'Access' => $this->checkAccess('user', 'index'),
            'Active' => $this->isActive('user')
        ];
        $menu[] = [
            'Title' => 'Промо-коды',
            'Url' => \Yii::app()->createUrl('/partner/coupon/index'),
            'Access' => $this->checkAccess('coupon', 'index'),
            'Active' => $this->isActive('coupon')
        ];
        $menu[] = [
            'Title' => 'Счета',
            'Url' => \Yii::app()->createUrl('/partner/order/index'),
            'Access' => $this->checkAccess('order', 'index'),
            'Active' => $this->isActive('order')
        ];
        $menu[] = [
            'Title' => 'Заказы',
            'Url' => \Yii::app()->createUrl('/partner/orderitem/index'),
            'Access' => $this->checkAccess('orderitem', 'index'),
            'Active' => $this->isActive('orderitem')
        ];
        $menu[] = [
            'Title' => 'Программа',
            'Url' => \Yii::app()->createUrl('/partner/program/index'),
            'Access' => $this->checkAccess('program', 'index'),
            'Active' => $this->isActive('program')
        ];
        $menu[] = [
            'Title' => 'Настройки',
            'Url' => \Yii::app()->createUrl('/partner/settings/roles'),
            'Access' => $this->checkAccess('settings', 'roles'),
            'Active' => $this->isActive('settings')
        ];
        /**
        if (!\Yii::app()->partner->isGuest)
        {
            $menu[] = [
                'Title' => 'Компетенции',
                'Url' => \Yii::app()->createUrl('/partner/competence/index'),
                'Access' => \competence\models\Test::model()->byEventId(\Yii::app()->partner->getAccount()->EventId)->exists(),
                'Active' => $this->isActive('competence')
            ];
        }
         **/

        $this->render('topMenu', ['menu' => $menu]);
    }

    protected function checkAccess($controller, $action)
    {
        return $this->getController()->getAccessFilter()->checkAccess('partner', $controller, $action);
    }

    protected function isActive($controller)
    {
        return $this->getController()->getId() == $controller;
    }
}