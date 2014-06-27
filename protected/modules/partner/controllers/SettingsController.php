<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 25.02.14
 * Time: 16:50
 */

class SettingsController extends \partner\components\Controller
{
  public function actions()
  {
    return [
      'roles' => '\partner\controllers\settings\RolesAction',
      'loyalty' => '\partner\controllers\settings\LoyaltyAction'
    ];
  }

  public function initBottomMenu()
  {
    $this->bottomMenu = [
      'roles' => [
        'Title' => 'Статусы',
        'Url' => \Yii::app()->createUrl('/settings/roles'),
        'Access' => $this->getAccessFilter()->checkAccess('partner', 'settings', 'roles')
      ],
      'loyalty' => [
        'Title' => 'Программа лояльности',
        'Url' => \Yii::app()->createUrl('/settings/loyalty'),
        'Access' => $this->getAccessFilter()->checkAccess('partner', 'settings', 'loyalty')
      ]
    ];
  }
} 