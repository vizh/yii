<?php
class PartnerCreateOrderIndex extends PartnerCommand 
{
    protected function doExecute() 
    {
        $this->SetTitle('Формирование заказа');
        
        $createOrder = Registry::GetRequestVar('CreateOrder', array('Step' => 1));
        
        $step = (int) $createOrder['Step'];
        if ($step == 0)
        {
            $step = 1;
        }
   
        if ( !empty ($createOrder['Payer']['RocId']))
        {
            $payer = User::GetByRocid($createOrder['Payer']['RocId']);
            if ($payer == null)
            {
                $step = 1;
            }
        }
        
        switch ($step)
        {
            case 1:
                break;
            
            case 2:
                break;
        }
        
        
        echo $this->view;
    }
}
?>
