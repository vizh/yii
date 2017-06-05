<?php
namespace competence\components;

class ErrorsWidget extends \CWidget
{
    /** @var \competence\models\form\Base */
    public $form;

    public function run()
    {
        $this->render('errors');
    }
}