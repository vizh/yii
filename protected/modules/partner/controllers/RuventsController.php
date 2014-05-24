<?php
class RuventsController extends \partner\components\Controller
{
    public function actions()
    {
        return array(
            'index' => '\partner\controllers\ruvents\IndexAction',
            'operator' => '\partner\controllers\ruvents\OperatorAction',
            'mobile' => '\partner\controllers\ruvents\MobileAction',
            'csvinfo' => '\partner\controllers\ruvents\CsvinfoAction',
            'userlog' => '\partner\controllers\ruvents\UserlogAction'
        );
    }

    public function initBottomMenu()
    {
        $this->bottomMenu = array(
            'index' => array(
                'Title' => 'Статистика',
                'Url' => \Yii::app()->createUrl('/partner/ruvents/index'),
                'Access' => $this->getAccessFilter()->checkAccess('partner', 'ruvents', 'index')
            ),
            'operator' => array(
                'Title' => 'Генерация операторов',
                'Url' => \Yii::app()->createUrl('/partner/ruvents/operator'),
                'Access' => $this->getAccessFilter()->checkAccess('partner', 'ruvents', 'operator')
            ),
            'csvinfo' => array(
                'Title' => 'Итоги мероприятия (csv)',
                'Url' => \Yii::app()->createUrl('/partner/ruvents/csvinfo'),
                'Access' => $this->getAccessFilter()->checkAccess('partner', 'ruvents', 'csvinfo')
            ),
        );
    }

}