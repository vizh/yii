<?php
abstract class ApiStaticKeyCommand extends ApiNonAuthCommand
{
  private $apiKey = 'v0LhzSBCS3';
  
  protected function preExecute() 
  {
    $_POST['ApiKey'] = $this->apiKey;
    parent::preExecute();
  }
}
