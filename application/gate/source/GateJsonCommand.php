<?php
AutoLoader::Import('library.rocid.user.*');
AutoLoader::Import('library.rocid.pay.*');

abstract class GateJsonCommand extends GateCommand
{
  protected $result = array('error' => false, 'code' => 0, 'message' => '');

  protected function preExecute()
  {

    $this->EventName = Registry::GetRequestVar('event');
    $this->token = Registry::GetRequestVar('token');

    /**
     * ID-адрес сервера, осущеставляющего запрос
     */
    $this->ip = $_SERVER['REMOTE_ADDR'];
    header("Content-type: text/json");
    if (!$this->checkAccess())
    {
      $this->SendJson(true, 101, 'Авторизовать мероприятие не удалось. Один из входящих параметров не корректен.');
    }
  }

  protected function SendJson($error = null, $code = null, $message = null)
  {
    $this->result['error'] = $error !== null ? $error : $this->result['error'];
    $this->result['code'] = $code !== null ? $code : $this->result['code'];
    $this->result['message'] = $message !== null ? $message : $this->result['message'];
    echo json_encode($this->result);
    self::postExecute();
    exit;
  }
}
