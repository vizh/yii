<?php
AutoLoader::Import('library.rocid.pay.*');
AutoLoader::Import('library.rocid.user.*');

class PartnerOrderItemIndex extends PartnerCommand
{
    const OrderItemsOnPage = 20;


    protected function doExecute() 
    {        
        
        $this->SetTitle('Заказы');
        
        $criteria = new CDbCriteria();
        $criteria->with = array(
            'Product',
            'Payer',
            'Owner'
        );
        $criteria->condition = '`Product`.`EventId` = :EventId';
        $criteria->params[':EventId'] = $this->Account->EventId;
        $criteria->order = 'OrderItemId DESC';
        
        $page = (int) Registry::GetRequestVar('page', 0);
        if ($page === 0) 
        {
            $page = 1;
        }
        
        $criteria->limit  = self::OrderItemsOnPage;
        $criteria->offset = self::OrderItemsOnPage * ($page-1);
        
        $filter = Registry::GetRequestVar('filter', array ('Deleted' => 0));
        if ( !empty ($filter))
        {
            foreach ($filter as $field => $value)
            {
                if ($value !== '')
                {
                    switch ($field)
                    {
                        case 'ProductId':
                            $criteria->addCondition('`t`.`ProductId` = :ProductId');
                            $criteria->params[':ProductId'] = (int) $value;
                            break;
                        
                        case 'Payer':
                        case 'Owner':
                            $criteria->addCondition('`'. $field .'`.`RocId` = :'.$field);
                            $criteria->params[':'.$field] = (int) $value;
                            break;
                        
                        case 'Deleted':
                        case 'Paid':
                            $criteria->addCondition('`t`.`'.$field.'` = :'. $field);
                            $criteria->params[':'.$field] = (int) $value;
                            break;
                        
                    }
                }
                else
                {
                    unset ($filter[$field]);
                }
            }
            $this->view->Filter = $filter;
        }
        
        if ( isset ($filter['Deleted'])
                && $filter['Deleted'] == 0)
        {
            $criteria->addCondition('`t`.`Deleted` = 1 AND `t`.`Paid` = 1', 'OR');
        }
        
        $this->view->OrderItems = OrderItem::model()->findAll($criteria);
        $this->view->Products = Product::model()->findAll('t.EventId = :EventId', array(':EventId' => $this->Account->EventId));
        $this->view->Paginator = new Paginator(
            RouteRegistry::GetUrl('partner', 'orderitem', 'index'). '?page=%s', $page, self::OrderItemsOnPage, OrderItem::model()->count($criteria), array('filter' => $this->view->Filter)
        );
        
        echo $this->view;
    }
}
