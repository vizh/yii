<?php
namespace event\widgets;

use event\components\Widget;
use event\components\WidgetPosition;
use Yii;

class About extends Widget
{

    public function getAttributeNames()
    {
        return ['AboutTitle'];
    }

    public function run()
    {
        $this->render('about', []);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return isset($this->AboutTitle)
            ? $this->AboutTitle
            : Yii::t('app', 'О мероприятии');
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
