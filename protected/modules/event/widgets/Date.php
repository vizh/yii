<?php
namespace event\widgets;

class Date extends \CWidget
{
    public $event;
    public $html = true;

    public function run()
    {
        $data = $this->render('date', ['event' => $this->event], true);
        if (!$this->html) {
            $data = strip_tags($data);
        }
        echo trim($data);
    }
}
