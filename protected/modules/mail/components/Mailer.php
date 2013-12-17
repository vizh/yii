<?php
namespace mail\components;

abstract class Mailer
{

  protected abstract function internalSend(Mail $mail);  
 
  public final function send(Mail $mail)
  { 
    $log = $mail->getLog();
    try 
    {
      $this->internalSend($mail);
    }
    catch (\Exception $e)
    {
      $log->setError($e->getMessage());
    }
    $log->save();
  }
}
