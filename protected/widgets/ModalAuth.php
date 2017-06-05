<?php
namespace application\widgets;

class ModalAuth extends \CWidget
{
    public $bootstrapVersion = 2;

    public function run()
    {
        $this->render('auth/modal-bootstrap'.$this->bootstrapVersion);
    }
}
