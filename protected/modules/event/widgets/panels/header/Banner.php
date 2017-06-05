<?php
namespace event\widgets\panels\header;

use event\components\WidgetAdminPanel;
use event\models\forms\widgets\header\Banner as WidgetBannerForm;

class Banner extends WidgetAdminPanel
{
    /**
     * @inheritdoc
     */
    public function getForm()
    {
        return new WidgetBannerForm($this->getWidget());
    }
}
