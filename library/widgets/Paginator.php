<?php

class Paginator
{
  const Pages = 13;
  
  private $view;
  private $url;
  private $getParams = '';
  
  public function __construct($baseUrl, $page, $perPage, $count, $getParams = array())
  {
    $count = ceil($count / $perPage);
    if ($count < 2)
    {
      $this->view = '';
      return;
    }
    $this->url = $baseUrl;
    if (! empty($getParams))
    {
      $this->getParams = '&' . http_build_query($getParams);
    }
    
    $this->view = new View();
    $this->view->SetTemplate('paginator', 'core', 'paginator', 'widgets', 'public');
    
    $this->view->Page = $page;
    $this->view->Count = $count;
    $this->view->BackLink = $this->getUrl($page > 1 ? $page-1 : 1);
    $this->view->NextLink = $this->getUrl($page < $count ? $page+1 : $count);
    
    $this->view->Pages = $this->getPagesHtml($page, $count);    
  }
  
  private function getPagesHtml($page, $count)
  {    
    $result = new ViewContainer();
    if ($count <= Paginator::Pages)
    {
      for ($i = 1; $i <= $count; $i++)
      {
        $view = new View();
        $view->SetTemplate('page', 'core', 'paginator', 'widgets', 'public');
        
        $view->Page = $i;
        $view->Url = $this->getUrl($i);
        $view->Current = $i == $page;
        
        $result->AddView($view);
      }
    }
    else
    {
      $center = ceil(Paginator::Pages / 2);
      if ($page < $center)
      {
        $start = 1;
        $end = Paginator::Pages;
      }
      else if ($page > $count - $center + 1)
      {
        $end = $count;
        $start = $count - Paginator::Pages + 1;
      }
      else
      {
        $start = $page - $center + 1;
        $end = $page + $center - 1; 
      }
      
      for ($i = $start; $i <= $end; $i++)
      {
        $view = new View();
        $view->SetTemplate('page', 'core', 'paginator', 'widgets', 'public');
        
        if (($i == $start && $i != 1) || ($i == $end && $i != $count))
        {
          $view->Page = '...';
        }
        else
        {
          $view->Page = $i;
        }        
        $view->Url = $this->getUrl($i);
        $view->Current = $i == $page;
        
        $result->AddView($view);
      }
    }
    
    return $result;
  }
  
  private function getUrl($page)
  {
    return sprintf($this->url, $page)  . $this->getParams;
  }  
  
  
  public function __toString()
  {
    if (is_object($this->view))
    {
      return $this->view->__toString();
    }
    else
    {
      return $this->view;
    }
  }
}
