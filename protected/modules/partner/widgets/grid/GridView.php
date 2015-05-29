<?php
namespace partner\widgets\grid;

use \application\widgets\grid\GridView as BaseGridView;

class GridView extends BaseGridView
{
    public function registerClientScript()
    {
        parent::registerClientScript();
        $clientScript = \Yii::app()->getClientScript();
    }

} 