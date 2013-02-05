<?php
namespace application\widgets;

class Paginator extends \CWidget
{
  const Pages = 13;
  
  public $count;
  public $perPage;
  public $params = array();
  public $page = null;
  
  public function init()
  {
    if ($this->page == null)
    {
      $this->page = (int) \Yii::app()->request->getParam('page', 1);
      if ($this->page <= 0)
      {
        $this->page = 1;
      }
    }
  }

  public function run()
  {
    $this->count = ceil($this->count / $this->perPage);
    if ($this->count < 2)
    {
      return;
    }
    $this->render('paginator', array('pages' => $this->getPages()));
  }

  private function getPages()
  {
    $pages = array();
    if ($this->count <= Paginator::Pages)
    {
      for ($i = 1; $i <= $this->count; $i++)
      {
        $page = new \stdClass();
        $page->value = $i;
        $page->url = $this->getUrl($i);
        $page->current = ($i == $this->page);
        $pages[] = $page;
      }
    }
    else
    {
      $center = ceil(Paginator::Pages / 2);
      if ($this->page < $center)
      {
        $start = 1;
        $end = Paginator::Pages;
      }
      else if ($this->page > $this->count - $center + 1)
      {
        $end = $this->count;
        $start = $this->count - Paginator::Pages + 1;
      }
      else
      {
        $start = $this->page - $center + 1;
        $end = $this->page + $center - 1;
      }

      for ($i = $start; $i <= $end; $i++)
      {

        if (($i == $start && $i != 1) || ($i == $end && $i != $this->count))
        {
          $value = '...';
        }
        else
        {
          $value = $i;
        }
        $page = new \stdClass();
        $page->value = $value;
        $page->url = $this->getUrl($i);
        $page->current = ($i == $this->page);
        $pages[] = $page;
      }
    }
    return $pages;
  }

  protected function getUrl($page)
  {
    $route = \Yii::app()->request->getPathInfo();
    $this->params['page'] = $page;
    $params = array_merge($_GET, $this->params);
    return \Yii::app()->createUrl($route, $params);
  }
}
