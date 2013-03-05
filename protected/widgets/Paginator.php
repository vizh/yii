<?php
namespace application\widgets;

class Paginator extends \CWidget
{
  /** @var \application\components\utility\Paginator */
  public $paginator = null;

  public function run()
  {
    $count = $this->paginator->getCountPages();
    if ($count < 2)
    {
      return;
    }
    $this->render('paginator');
  }
}
