<?php
AutoLoader::Import('library.rocid.contact.*');
AutoLoader::Import('library.rocid.user.*');

class UserSocialCheck extends ApiCommand
{
  protected function doExecute() 
  {
    $socialId = Registry::GetRequestVar('SocialId', null);
    $socialUserId = Registry::GetRequestVar('SocialUserId', null);
    
    $socialService = ContactServiceType::model()->find('t.Protocol = :SocialId', array('SocialId' => $socialId));
    if ($socialService !== null)
    {
      $userConnect = UserConnect::GetByHash($socialUserId, $socialService->ServiceTypeId);
      if ($userConnect != null)
      {
        $user = User::GetById($userConnect->UserId);
        
        $this->Account->DataBuilder()->CreateUser($user);
        $this->Account->DataBuilder()->BuildUserEmail($user);
        $this->Account->DataBuilder()->BuildUserEmployment($user);
        $result = $this->Account->DataBuilder()->BuildUserEvent($user);
        $this->SendJson($result);
      }
      else
      {
        throw new ApiException(220);
      }
    }
    else
    {
      throw new ApiException(221);
    }
  }
}