<?php

namespace application\widgets;

class Searchbar extends \CWidget
{
    public function run()
    {
        $value = \Yii::app()->getRequest()->getQuery('term');

        if (!is_string($value)) {
            $value = '';
        }

        $this->render('searchbar', [
            'value' => $value
        ]);
    }
}
