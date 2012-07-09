<?php
class PartnerOrderItemAdd extends PartnerCommand
{
    protected function doExecute() 
    {
        $this->SetTitle('Добавление заказа');
        echo $this->view;
    }
}
