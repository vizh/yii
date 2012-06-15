<?php

class ConvertAll extends AbstractCommand
{
  protected function preExecute()
  {
    parent::preExecute();
    
    $this->view->HeadScript(array('src'=>'/js/convert.js'));
    
    header('Content-Type: text/html; charset=utf-8');
    $this->view->SetLayout('main');
  }
  
  protected function doExecute()
  {
    //echo 'Already doing';
    //exit;
    
    echo $this->view;
  }
}
