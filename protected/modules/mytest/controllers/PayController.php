<?php

class PayController extends \application\components\controllers\PublicController
{
    public function actionRedirect()
    {
        return;
        /** @var $paidItems \pay\models\OrderItem[] */
        $paidItems = \pay\models\OrderItem::model()
            ->byOwnerId(2682)
            ->byRedirectId(null)
            ->byRedirectId(2682, false)
            ->byEventId(246)
            ->byPaid(1)->with(['Product', 'Payer', 'Owner', 'RedirectUser'])->findAll();

        foreach ($paidItems as $item) {
            echo $item->OrderItemId.'<br>';
        }

        $logger = Yii::getLogger();
        $logs = $logger->getProfilingResults();
        echo '<pre>';
        print_r($logs);
        echo '</pre>';
    }
}


/*

    (



  (


  (

  ((t.OwnerId = :OwnerId) AND (t.RedirectId IS NULL))

  OR (t.RedirectId = :RedirectId)


  ) AND (Product.EventId = :EventId)) AND (t.Paid = :Paid)



  )



  */
