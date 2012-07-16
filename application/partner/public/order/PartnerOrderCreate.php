<?php
AutoLoader::Import('library.rocid.user.*');
AutoLoader::Import('library.rocid.pay.*');

class PartnerOrderCreate extends PartnerCommand 
{
    private $Payer = null;
    
    protected function doExecute($payerRocId = 0) 
    {
        $this->SetTitle('Выставление счета');
        if ($payerRocId != 0)
        {
            $this->Payer = User::GetByRocid($payerRocId);
            $this->stepCreateOrder();
        }
        else
        {
            $this->stepIndex();
        }
        echo $this->view;
    }
    
    private function stepIndex ()
    {
        $view = new View();
        $view->SetTemplate('stepIndex');
        
        if ( yii::app()->request->getIsPostRequest() 
                && isset ($_REQUEST['CreateOrder']))
        {
            $createOrder = Registry::GetRequestVar('CreateOrder');
            if ( !empty ($createOrder))
            {
                $payerRocId = (int) $createOrder['Payer']['RocId'];
                if ($payerRocId != 0)
                {
                    Lib::Redirect(
                        RouteRegistry::GetUrl('partner', 'order', 'create', array('payerRocId' => $payerRocId))
                    );
                }
                else
                {
                    $this->view->Error = 'Не указан плательщик';
                }
            }
        }
        $this->view->Form = $view;
    }
    
    private function stepCreateOrder ()
    {
        if ( !isset ($this->Payer))
        {
            $this->stepIndex();
            $this->view->Error = 'Плательщик не найден';
            return;
        }
        
        $view = new View();
        $view->SetTemplate('stepCreateOrder');
        
        $view->Payer = $this->Payer;
        $allOrderItems = OrderItem::GetByEventId($this->Payer->UserId, $this->Account->EventId);
        $orderItems = array();
        
        if ( !empty ($allOrderItems))
        {
            foreach ($allOrderItems as $orderItem)
            {
                if ( $orderItem->Product->ProductManager()->CheckProduct( $orderItem->Owner))
                {
                    $orderItems[] = $orderItem;
                }
                else
                {
                    $orderItem->Deleted = 1;
                    $orderItem->save();
                }
            }            
        }
        
        if ( empty ($orderItems))
        {
            $this->stepIndex();
            $this->view->Error = 'На пользователя с rocID: '. $this->Payer->RocId .' нет ни одного заказа';
            return;
        }
        else
        {
            $view->OrderItems = $orderItems;
        }
        
        if ( yii::app()->request->getIsPostRequest()
                && isset ($_REQUEST['CreateOrder']))
        {
            $createOrder = Registry::GetRequestVar('CreateOrder');
            if ( $this->createOrderValidateForm($createOrder))
            {
                Order::CreateOrder($this->Payer, $this->Account->EventId, $createOrder);
                Lib::Redirect(
                    RouteRegistry::GetUrl('partner', 'order', 'search') .'?filter[PayerRocId]='. $this->Payer->RocId 
                );
            }
            else
            {
                $this->view->Error = 'Необходимо заполнить все поля данных юр. лиц.';
            }
        }
        
        
        $this->view->Form = $view;
    }
    
    private function createOrderValidateForm ($data)
    {
        return !empty($data['Name']) && !empty($data['Address']) && !empty($data['INN']) && !empty($data['KPP']) && !empty($data['Phone']) && !empty($data['PostAddress']);
    }
}
?>
