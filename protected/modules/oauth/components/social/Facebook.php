<?php
namespace oauth\components\social;

class Facebook implements ISocial
{
  const AppId = 331368426975443;
  const Secret = '4789502ae8826d7d40771b649b2951ef';


  /** @var \Facebook */
  protected $connection = null;


  public function getConnection()
  {
    if ($this->connection == null)
    {
      $this->connection = new \Facebook(array(
        'appId' => self::AppId,
        'secret' => self::Secret,
        'cookie' => true
      ));
    }

    return $this->connection;
  }

  public function getOAuthUrl()
  {
    return $this->getConnection()->getLoginUrl(array('scope' => 'email'));
  }

  public function isHasAccess()
  {
    $user = $this->getConnection()->getUser();
    return !empty($user);
  }

  public function getData()
  {
    if ($this->isHasAccess())
    {
      $user_profile = $this->getConnection()->api('/me');
      $data = new Data();

      $data->Hash = $user_profile['id'];
      $data->UserName = $user_profile['username'];

      $data->LastName = $user_profile['last_name'];
      $data->FirstName = $user_profile['first_name'];
      $data->Email = $user_profile['email'];
      return $data;
    }
    else
    {
      return new Data();
    }
  }

  public function getSocialId()
  {
    return self::Facebook;
  }

  /**
   * @return void
   */
  public function renderScript()
  {
    //empty for FB
  }

  /**
   * @return string
   */
  public function getSocialTitle()
  {
    return 'Facebook';
  }
}

require dirname(__FILE__) . '/facebook/facebook.php';