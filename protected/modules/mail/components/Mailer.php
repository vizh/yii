<?php
namespace mail\components;

abstract class Mailer
{

  protected abstract function internalSend(Mail $mail);  
 
  public function send(Mail $mail, $hashSolt = null, $repeat = false)
  { 
    $hash = md5(get_class($mail).$mail->getTo().$mail->getSubject());
    if ($hashSolt !== null)
    {
      $hash .= $hashSolt;
    }
    
    if (!$repeat)
    {
      $log = \mail\models\Log::model()->byHash($hash)->find();
      if ($log !== null)
        return;
    }
    
    $log = new \mail\models\Log();
    $log->From = $mail->getFrom();
    $log->To   = $mail->getTo();
    $log->Subject = $mail->getSubject();
    $log->Hash = $hash;
    
    try 
    {
      $this->internalSend($mail);
    }
    catch (\Exception $e)
    {
      $log->Error = $e->getMessage();
    }
    $log->save();
  }
}
