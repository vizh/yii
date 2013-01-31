<?php
namespace oauth\components\social;

class Proxy implements ISocial
{
  /**
   * @var ISocial
   */
  protected $social;

  public function __construct($socialName)
  {
    switch ($socialName)
    {
      case 'facebook':
        $this->social = new Facebook();
        break;
      case 'twitter':
        $this->social = new Twitter();
        break;
      default:
        throw new \CHttpException(400, 'Не обнаружена авторизация по OAuth с идентификатором "' . $socialName . '"');
    }
  }

  public function getOAuthUrl()
  {
    return $this->social->getOAuthUrl();
  }

  public function isHasAccess()
  {
    return ($this->data !== null) || $this->social->isHasAccess();
  }

  protected $data = null;
  public function getData()
  {
    if ($this->data == null)
    {
      $this->data = $this->social->getData();
    }
    return $this->data;
  }

  public function getSocialId()
  {
    return $this->social->getSocialId();
  }

  /**
   * @param $hash
   * @return \user\models\Connect|null
   */
  public function getConnect($hash)
  {
    return \user\models\Connect::model()->byServiceTypeId($this->getSocialId())->byHash($hash)->find();
  }
  
  /**
   *
   * @param \user\models\User $user 
   * @return \user\models\Connect
   */
  public function addConnect(\user\models\User $user)
  { 
    $criteria = new \CDbCriteria();
    $criteria->condition = 't.UserId = :UserId AND t.ServiceTypeId = :ServiceTypeId';
    $criteria->params['UserId'] = $user->UserId;
    $criteria->params['ServiceTypeId'] = $this->getSocialId();
    $connect = \user\models\Connect::model()->find($criteria);
    if ($connect == null)
    {
      $connect = new \user\models\Connect();
      $connect->UserId = $user->UserId;
      $connect->ServiceTypeId = $this->getSocialId();
    }
    $connect->Hash = $this->getData()->Hash;
    $connect->save();
    return $connect;
  }
  
  /**
   *
   * @param \user\models\User $user 
   */
  public function addContact(\user\models\User $user)
  {
    if (!empty($user->ServiceAccounts))
    {
      foreach ($user->ServiceAccounts as $account)
      {
        if ($account->ServiceTypeId == $this->getSocialId())
        {
          $account->Account = $this->getData()->UserName;
          $account->save();
          return;
        }
      }
    }
    
    $contact = new \contact\models\ServiceAccount();
    $contact->ServiceTypeId = $this->getSocialId();
    $contact->Account = $this->getData()->UserName;
    $contact->Visibility = 1;
    $contact->save();
    $user->AddServiceAccount($contact);
    return;
  }
}