<?php

namespace application\widgets;

class Paginator extends \CWidget
{
    /** @var \application\components\utility\Paginator */
    public $paginator;

    public function run()
    {
        if ($this->paginator->getCountPages() >= 2) {
            $this->render('paginator');
        }
    }
}
