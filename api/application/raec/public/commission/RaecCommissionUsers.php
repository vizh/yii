<?php
AutoLoader::Import('comission.source.*');
AutoLoader::Import('library.rocid.user.*');

class RaecCommissionUsers extends ApiStaticKeyCommand
{
  protected function doExecute() 
  {
    $commissionId = (int) Registry::GetRequestVar('CommissionId', 0);
    $commission = Comission::GetById($commissionId);
    if ($commission === null)
    {
      throw new ApiException(601, array($commissionId));
    }
    
    $result = array();
    $commissionUsers = ComissionUser::GetByComissionId($commission->ComissionId);
    foreach ($commissionUsers as $commissionUser)
    {
      $this->Account->DataBuilder()->CreateUser($commissionUser->User);
      $this->Account->DataBuilder()->BuildUserEmployment($commissionUser->User);
      $result['Users'][] = $this->Account->DataBuilder()->BuildUserCommission($commissionUser->Role);
    }
    $this->SendJson($result);
  }
}
