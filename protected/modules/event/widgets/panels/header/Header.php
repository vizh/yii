<?php
namespace event\widgets\panels\header;

use event\components\WidgetAdminPanel;
use event\models\forms\widgets\header\Header as WidgetHeaderForm;

class Header extends WidgetAdminPanel
{
    /**
     * @inheritdoc
     */
    public function getForm()
    {
        return new WidgetHeaderForm($this->getWidget());
    }
}
