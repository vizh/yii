<?php
namespace oauth\components\social;

class Viadeo implements ISocial
{
  const AppId = 'RUNETIDOqOAuB';
  const Secret = 'XFkix6MwlRPWO';


  /** @var \ViadeoAPI */
  protected $connection = null;

  function __construct()
  {
    $this->connection = new \ViadeoAPI();
    $this->connection->init([
      'store' => true,
      'client_id' => self::AppId,
      'client_secret' => self::Secret
    ]);

    $me = $this->connection->get("/me")->execute();
    echo '<pre>';
    print_r($me);
    echo '</pre>';
    exit;
  }


  /**
   * @return string
   */
  public function getOAuthUrl()
  {
    // TODO: Implement getOAuthUrl() method.
  }

  /**
   * @return bool
   */
  public function isHasAccess()
  {
    // TODO: Implement isHasAccess() method.
  }

  /**
   * @return void
   */
  public function renderScript()
  {
    // TODO: Implement renderScript() method.
  }

  /**
   * @return Data
   */
  public function getData()
  {
    // TODO: Implement getData() method.
  }

  /**
   * @return int
   */
  public function getSocialId()
  {
    // TODO: Implement getSocialId() method.
  }

  /**
   * @return string
   */
  public function getSocialTitle()
  {
    // TODO: Implement getSocialTitle() method.
  }

  /**
   * @return void
   */
  public function clearAccess()
  {
    // TODO: Implement clearAccess() method.
  }
}

require dirname(__FILE__) . '/viadeo/viadeoapi.inc.php';