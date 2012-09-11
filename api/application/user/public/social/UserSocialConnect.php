<?php
AutoLoader::Import('library.rocid.contact.*');
AutoLoader::Import('library.rocid.user.*');

class UserSocialConnect extends ApiCommand
{
  protected function doExecute() 
  {
    $rocId = Registry::GetRequestVar('RocId', null);
    $socialId = Registry::GetRequestVar('SocialId', null);
    $socialUserId = Registry::GetRequestVar('SocialUserId', null);
   
    $user = User::GetByRocid($rocId);
    if ($user === null)
    {
      throw new ApiException(202, array($rocId));
    }
    
    $socialService = ContactServiceType::model()->find('t.Protocol = :SocialId', array('SocialId' => $socialId));
    if ($socialService === null)
    {
      throw new ApiException(221);
    }
    
    $userConnect = UserConnect::GetByUser($user->UserId, $socialService->ServiceTypeId);
    if ($userConnect !== null)
    {
      $userConnect->Hash = $socialUserId;
    }
    else 
    {
      $userConnect = new UserConnect();
      $userConnect->UserId = $user->UserId;
      $userConnect->ServiceTypeId = $socialService->ServiceTypeId;
      $userConnect->Hash = $socialUserId;
    }
    $userConnect->save();
    
    $result = new stdClass();
    $result->Success = true;
    $this->SendJson($result);
  }
}