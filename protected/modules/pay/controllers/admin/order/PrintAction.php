<?php

namespace pay\controllers\admin\order;


class PrintAction extends \CAction
{
  const EVENT_ID = 789;

  public function run()
  {
    $this->getController()->setPageTitle(\Yii::t('app','Печать счетов'));
    $criteria = new \CDbCriteria();
    $criteria->order = '"t"."PaidTime" ASC';
    $count = \pay\models\Order::model()->byEventId(self::EVENT_ID)->byPaid(true)->byJuridical(true)->count();
    $paginator = new \application\components\utility\Paginator($count, ['print' => 1]);
    $paginator->perPage = 50;

    if (\Yii::app()->getRequest()->getParam('print') !== null)
    {
      $criteria->mergeWith($paginator->getCriteria());
      $orders = \pay\models\Order::model()->byEventId(self::EVENT_ID)->byPaid(true)->byJuridical(true)->findAll($criteria);
      $content = '';
      foreach ($orders as $order)
      {
        $this->getController()->layout = '/layouts/bill';
        $view = $this->getController()->renderPartial('pay.views.order.'.str_replace('/','.',$order->getViewName()), [
          'order' => $order,
          'billData' => $order->getBillData()->Data,
          'total' => $order->getBillData()->Total,
          'nds' => $order->getBillData()->Nds,
          'withSign' => false,
          'template' => $order->getViewTemplate()
        ], true);
        $content .= '<div style="page-break-after: always;">'.$view.'</div>';
      }
      \Yii::app()->getClientScript()->reset();
      $cssPath = \Yii::getPathOfAlias('pay.assets.css.order.index').'.css';
      \Yii::app()->getClientScript()->registerCssFile(\Yii::app()->getAssetManager()->publish($cssPath));
      $this->getController()->renderText($content);
      \Yii::app()->end();
    }
    $this->getController()->render('print', ['paginator' => $paginator]);
  }
} 