<?php
namespace application\widgets;

class Paginator extends \CWidget
{
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

    $this->render('paginator');
  }
}
