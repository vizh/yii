<?php
AutoLoader::Import('library.rocid.pay.*');
AutoLoader::Import('library.rocid.user.*');

class PartnerOrderItemAdd extends PartnerCommand
{
    protected function doExecute() 
    {
        $this->SetTitle('Добавление заказа');
        
        $this->view->HeadScript( array ('src'=>'/js/libs/jquery-ui-1.8.16.custom.min.js'));
        $this->view->HeadLink(
            array('rel' => 'stylesheet', 'type' => 'text/css', 'href' => '/css/blitzer/jquery-ui-1.8.16.custom.css')
        );
        
        $this->view->Products = Product::model()->findAll('t.EventId = :EventId', array(':EventId' => $this->Account->EventId));
        
        if (yii::app()->request->getIsPostRequest()
                && isset ($_REQUEST['OrderItem']))
        {
            $orderItem = Registry::GetRequestVar('OrderItem', array());
           
            $product = Product::GetById($orderItem['ProductId']);
            $payer   = User::GetByRocid($orderItem['PayerRocId']);
            $owner   = User::GetByRocid($orderItem['OwnerRocId']);
            
            if ( empty ($product))
            {
                $this->view->Error = 'Не найден продукт';
            }
            else if ( empty ($payer))
            {
                $this->view->Error = 'Не найден плательщик';
            }
            else if ( empty ($owner))
            {
                $this->view->Error = 'Не найден получатель';
            }
            
            if ( !isset ($this->view->Error))
            {
                $orderItemId = $product->ProductManager()->CreateOrderItem($payer, $owner)->OrderItemId;
                Lib::Redirect( 
                    RouteRegistry::GetUrl('partner', 'orderitem', 'index') . '?' . http_build_query( array ('filter' => array('OrderItemId' => $orderItemId)))
                );
            }
            else
            {
                $this->view->Product = $product;
                $this->view->Payer   = $payer;
                $this->view->Owner   = $owner;
            }
        }
        echo $this->view;
    }
}