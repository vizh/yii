<?php
namespace application\widgets;

class Paginator extends \CWidget
{
  const Pages = 13;

  public $url;
  public $count;
  public $page;
  public $perPage;
  public $params = array();

  public function run()
  {
    $this->count = ceil($this->count / $this->perPage);
    if ($this->count < 2)
    {
      return;
    }
    $pages = $this->getPages();
    $this->render('paginator', array('pages' => $pages));
  }

  private function getPages()
  {
    $pages = '';
    if ($this->count <= Paginator::Pages)
    {
      for ($i = 1; $i <= $this->count; $i++)
      {
        $pages .= $this->render('page', array('value' => $i, 'url' => $this->getUrl($i), 'current' => ($i == $this->page)), true);
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
        $pages .= $this->render('page', array('value' => $value, 'url' => $this->getUrl($i), 'current' => ($i == $this->page)), true);
      }
    }

    return $pages;
  }

  private function getUrl($page)
  {
    return \Yii::app()->createUrl($this->url, array_merge(array('page' => $page), $this->params));
  }
}
