<?php
AutoLoader::Import('library.rocid.pay.*');
AutoLoader::Import('library.rocid.event.*');
AutoLoader::Import('library.rocid.user.*');

class PartnerOrderSearch extends PartnerCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $this->SetTitle('Поиск счета');

      if ( Yii::app()->request->getIsPostRequest())
      {
          $criteria = new CDbCriteria();
          $criteria->condition = 'OrderJuridical.OrderId IS NOT NULL AND t.EventId = :EventId';
          $criteria->params = array(
              'EventId' => $this->Account->EventId
          );
          $criteria->with = array(
              'OrderJuridical',
              'Payer',
              'Payer.Phones',
              'Payer.Emails'
          );
          
          $filter = Registry::GetRequestVar('filter', array());
          $this->view->Filter = $filter;
          
          if ( !empty ($filter['OrderId']))
          {
              $criteria->addCondition('t.OrderId = :OrderId');
              $criteria->params[':OrderId'] = $filter['OrderId'];
          }
          else if ( !empty ($filter['CompanyName']))
          {
              $criteria->addCondition('OrderJuridical.Name LIKE :CompanyName');
              $criteria->params[':CompanyName'] = '%'.$filter['CompanyName'].'%';
          }
          else if ( !empty ($filter['PayerRocId'])) 
          {
              $criteria->addCondition('Payer.RocId = :PayerRocId');
              $criteria->params[':PayerRocId'] = $filter['PayerRocId'];
          }
          else
          {
              $this->view->Filter = array();
              echo $this->view;
              return;
          }
          $this->view->Orders = Order::model()->findAll($criteria);
      }
      echo $this->view;
  }
}
