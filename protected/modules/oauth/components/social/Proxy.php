<?php
namespace oauth\components\social;

class Proxy implements ISocial
{
  /**
   * @var ISocial
   */
  protected $social;

  public function __construct($socialName, $redirectUrl = null)
  {
    switch ($socialName)
    {
      case ISocial::Facebook:
        $this->social = new Facebook($redirectUrl);
        break;
      case ISocial::Twitter:
        $this->social = new Twitter();
        break;
      case ISocial::Vkontakte:
        $this->social = new Vkontakte($redirectUrl);
        break;
      case ISocial::Google:
        $this->social = new Google($redirectUrl);
        break;
      case ISocial::PayPal:
        $this->social = new PayPal($redirectUrl);
        break;
      case ISocial::Linkedin:
        $this->social = new Linkedin($redirectUrl);
        break;
      case ISocial::Ok:
        $this->social = new Ok($redirectUrl);
        break;
      default:
        throw new \CHttpException(400, 'Не обнаружена авторизация по OAuth с идентификатором "' . $socialName . '"');
        break;
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
  public function getSocial($hash, $dublicates = false)
  {
      if($dublicates){
          return \oauth\models\Social::model()->byHash($hash)->bySocialId($this->getSocialId())->findAll();
      }else{
          return \oauth\models\Social::model()->byHash($hash)->bySocialId($this->getSocialId())->find();
      }
  }

  /**
   * @param \user\models\User $user
   */
  public function saveSocialData($user)
  {
    $this->saveSocial($user);
    if ($this->getData()->UserName !== null)
    {
      $this->saveServiceAccount($user);
    }
    $this->clearAccess();
  }

  /**
   * @param \user\models\User $user
   */
  protected function saveSocial(\user\models\User $user)
  {
    $social = \oauth\models\Social::model()
        ->byUserId($user->Id)
        ->bySocialId($this->getSocialId())->find();
    if ($social === null)
    {
      $social = new \oauth\models\Social();
      $social->UserId = $user->Id;
      $social->SocialId = $this->getSocialId();
    }
    $social->Hash = (string)$this->getData()->Hash;
    $social->save();
  }

  /**
   * @param \user\models\User $user
   */
  protected function saveServiceAccount(\user\models\User $user)
  {
    foreach ($user->LinkServiceAccounts as $link)
    {
      if ($link->ServiceAccount->TypeId == $this->getSocialId())
      {
        $link->ServiceAccount->Account = $this->getData()->UserName;
        $link->ServiceAccount->save();
        return;
      }
    }


    $account = new \contact\models\ServiceAccount();
    $account->TypeId = $this->getSocialId();
    $account->Account = $this->getData()->UserName;
    $account->save();

    $link = new \user\models\LinkServiceAccount();
    $link->ServiceAccountId = $account->Id;
    $link->UserId = $user->Id;
    $link->save();
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

  public function clearAccess()
  {
    $this->social->clearAccess();
  }
}
