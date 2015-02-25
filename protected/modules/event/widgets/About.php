<?php
namespace event\widgets;

use event\components\Widget;
use event\components\WidgetPosition;

class About extends Widget
{

    public function run()
    {
        $this->render('about', array());
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return \Yii::t('app', 'О мероприятии');
    }

    /**
     * @return string
     */
    public function getPosition()
    {
        return WidgetPosition::Tabs;
    }

    /**
     * @inheritdoc
     */
    public function getIsHasDefaultResources()
    {
        return true;
    }
}
