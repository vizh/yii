<?php

namespace pay\controllers\admin\order;


class PrintAction extends \CAction
{
  public function run()
  {
    $request = \Yii::app()->getRequest();

    $paginator = null;
    $event = null;

    $form = new \pay\models\forms\admin\OrderPrint();
    $form->attributes = $request->getParam(get_class($form));
    if ($request->getParam('find') !== null && $form->validate())
    {
      $event = \event\models\Event::model()->findByPk($form->EventId);
      if ($event == null)
        throw new \CHttpException(404);

      $criteria = new \CDbCriteria();
      $criteria->order = '"t"."PaidTime" ASC';
      $criteria->addCondition('"t"."EventId" = :EventId AND "t"."Paid"');
      $criteria->params['EventId'] = $event->Id;
      if (!empty($form->DateFrom))
      {
        $criteria->addCondition('"t"."PaidTime" >= :DateFrom');
        $criteria->params['DateFrom'] = \Yii::app()->getDateFormatter()->format('yyyy-MM-dd', $form->DateFrom).' 00:00:00';
      }
      $count = \pay\models\Order::model()->byJuridical(true)->count($criteria);
      $paginator = new \application\components\utility\Paginator($count, ['print' => 1]);
      $paginator->perPage = 50;

      if ($request->getParam('print') !== null)
      {
        $this->getController()->layout = '/layouts/bill';
        $criteria->mergeWith($paginator->getCriteria());
        $orders = \pay\models\Order::model()->byJuridical(true)->findAll($criteria);
        $content = '';
        foreach ($orders as $order)
        {
          $content.=$this->renderOrder($order);
        }
        \Yii::app()->getClientScript()->reset();
        $cssPath = \Yii::getPathOfAlias('pay.assets.css.order.index').'.css';
        \Yii::app()->getClientScript()->registerCssFile(\Yii::app()->getAssetManager()->publish($cssPath));
        $this->getController()->renderText($content);
        \Yii::app()->end();
      }
    }
    $this->getController()->setPageTitle(\Yii::t('app','Печать счетов'));
    $this->getController()->render('print', ['paginator' => $paginator,'form' => $form, 'event' => $event]);
  }

  private function renderOrder(\pay\models\Order $order)
  {
    $result = $this->getController()->renderPartial('pay.views.order.'.str_replace('/','.',$order->getViewName()), [
      'order' => $order,
      'billData' => $order->getBillData()->Data,
      'total' => $order->getBillData()->Total,
      'nds' => $order->getBillData()->Nds,
      'withSign' => false,
      'template' => $order->getViewTemplate()
    ], true);
    $result = '<div style="page-break-after: always;">'.$result.'</div>';
    return $result;
  }
} 