<?php
AutoLoader::Import('comission.source.*');
class RaecCommissionList extends ApiStaticKeyCommand
{
  protected function doExecute() 
  {
    $commisions = Comission::GetAll(false);
    $result = array();
    foreach ($commisions as $commision)
    {
      $result['Commissions'][] = $this->Account->DataBuilder()->CreateCommision($commision);
    }
    $this->SendJson($result);
  }
}