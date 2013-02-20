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
      case ISocial::Facebook:
        $this->social = new Facebook();
        break;
      case ISocial::Twitter:
        $this->social = new Twitter();
        break;
      case ISocial::Vkontakte:
        $this->social = new Vkontakte();
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

  /**
   * @return Data
   */
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
   * @return \oauth\models\Social|null
   */
  public function getSocial($hash)
  {
    return \oauth\models\Social::model()->byHash($hash)->bySocialId($this->getSocialId())->find();
  }

  /**
   * @param \user\models\User $user
   */
  public function addSocial($user)
  {

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

  /**
   * @return void
   */
  public function renderScript()
  {
    $this->social->renderScript();
  }

  /**
   * @return string
   */
  public function getSocialTitle()
  {
    return $this->social->getSocialTitle();
  }
}