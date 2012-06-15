<?php

abstract class AjaxNonAuthCommand extends AbstractCommand
{
  protected function preExecute()
  {
    parent::preExecute();
    
    header('Content-Type: text/html; charset=utf-8');    
    $this->view->UseLayout(false);
  }  
}