<?php
AutoLoader::Import('gate.source.GateUser');

abstract class GateCommand extends AbstractCommand
{
  protected $EventName;
  protected $ip;
  protected $token;

  private $goodCommands = array('login', 'new', 'registration', 'participants', 'user', 'section', 'test', 'role');

  protected function preExecute()
  {
    parent::preExecute();

//    if (!in_array(RouteRegistry::GetInstance()->GetCommand(), $this->goodCommands))
//    {
//      exit();
//    }

    $this->EventName = Registry::GetRequestVar('event');
    $this->token = Registry::GetRequestVar('token');

    /**
     * ID-адрес сервера, осущеставляющего запрос
     */
    $this->ip = $_SERVER['REMOTE_ADDR'];
    header("Content-type: text/xml");
    if (!$this->checkAccess())
    {
      print_r($_SERVER);
      print_r($_REQUEST);
      $this->SendResponse(101);
    }
  }

  protected function postExecute()
  {
    parent::postExecute();

    $logger = Yii::getLogger();
    $stats = Yii::app()->db->getStats();
    $logs = $logger->getProfilingResults();

    ob_start();
    echo ' SQL queries: ' . $stats[0] .
         ' SQL Execution Time: ' . $stats[1] .
         ' Full Execution Time: ' . $logger->getExecutionTime();
    $logs = ob_get_clean();

    $request = serialize($_REQUEST);
    // Логируем
    $msg = date('Y-m-d H:i:s') . "\t" . $_SERVER['REQUEST_URI'] . "\t Execution Time:" . $logger->getExecutionTime() . "\t" . $request . "\n";
    $this->Log($msg);




//    if ($this->EventName == 'riw11')
//    {
//      $file = fopen('riw11-gate.log', 'a');
//      fwrite($file, date('Y-m-d H:i:s') . "\t" . $_SERVER['REQUEST_URI'] . "\t Execution Time:" . $logger->getExecutionTime() . "\t" . $request . "\n");
//      fclose($file);
//    }
  }

  public static function GetToken($event, $ip)
  {
    return substr(md5("$event:$ip" . crc32("$event:$ip")), 5, 15);
  }

  protected function checkAccess()
  {
    $check = GateCommand::GetToken($this->EventName, $this->ip);
    // Сравнение ключей
    return ($check == $this->token);
  }

  protected function SendResponse($code, $data = null)
  {
    // Переменная для хранения дополнительных полей в XML-формате
    $extra = '';

    if (is_array($data) && !empty($data))
    {
      foreach ($data as $key => $value)
      {
        $extra .= '<user>';
        if (is_array($value))
        {
          foreach ($value as $skey => $svalue)
          {
            $extra .= $this->getNode($skey, $svalue);
          }
        } else
        {
          $extra .= $this->getNode($key, $value);
        }
        $extra .= '</user>';
      }
    }

    // Формирование и отправка ответа
    printf(
		'<?xml version="1.0" encoding="windows-1251"?>'.
		'<response>'.
			'<error-code>%u</error-code>'.
			'%s'.
		'</response>',
		$code,
		$extra
    );
    if ($code != 0)
    {
      $this->postExecute();
      exit();
    }
  }

  private function getNode($key, $value)
  {
    if ($value != '')
    {
      return sprintf('<%s>%s</%s>', $key, $value, $key);
    }
  }

  protected function Log($msg)
  {
    $log = "gate.log";
    $fh = fopen($log, 'a') or die("can't open file");
    //    fwrite($fh, time() ."\t". $this->EventName . ':' . $this->ip ."\t". $this->token ."\t". 'Section:' . RouteRegistry::GetInstance()->GetSection() . ' Command:' . RouteRegistry::GetInstance()->GetCommand() . "\t" . $logs . "\t" . $request ."\n");
    //    fclose($fh);
    fwrite($fh, $msg);
    fclose($fh);
  }

//  protected function AddDomTextNode($parent, $text)
//  {
//    $text = iconv('cp1251', 'utf8', $text);
//    $textNode = new DOMText($text);
//    return $parent->appendChild($textNode);
//  }
}