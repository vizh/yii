<?php
AutoLoader::Import('library.rocid.pay.*');
AutoLoader::Import('library.rocid.event.*');

class PartnerOrderIndex extends PartnerCommand
{
  const OrdersOnPage = 20;

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $this->SetTitle('Список счетов');

    $filter = Registry::GetRequestVar('filter', null);
    $page = intval(Registry::GetRequestVar('page', null));
    $page = $page > 1 ? $page : 1;



    $criteria = new CDbCriteria();
    $criteria->with = array(
        'OrderJuridical' => array('together' => true),
        'Payer',
        'Payer.Emails',
        'Payer.Phones'
    );
    $criteria->condition = 'OrderJuridical.OrderId IS NOT NULL AND t.EventId = :EventId';
    $criteria->params = array(':EventId' => $this->Account->EventId);
    
    if ($filter == 'active')
    {
      $criteria->addCondition('OrderJuridical.Paid = :Paid');
      $criteria->params[':Paid'] = 1;
    }
    else
    {
      $criteria->addCondition('OrderJuridical.Paid = :Paid AND OrderJuridical.Deleted = :Deleted');
      $criteria->params[':Paid'] = 0;
      $criteria->params[':Deleted'] = 0;
    }

    $count = Order::model()->count($criteria);

    $criteria->limit = self::OrdersOnPage;
    $criteria->offset = ($page - 1) * self::OrdersOnPage;
    $criteria->order = 't.CreationTime DESC';

    $this->view->Orders = Order::model()->with(array('Items' => array('together' => false)))->findAll($criteria);

    $this->view->Paginator = new Paginator(RouteRegistry::GetUrl('partner', 'order', 'index') . '?page=%s', $page, self::OrdersOnPage, $count, array('filter' => $filter));

    $this->view->Count = $count;
    $this->view->Filter = $filter;
    echo $this->view;
  }
}
