<?php
namespace event\widgets;

class Location extends \event\components\Widget
{

    public function run()
    {
        $this->render('location', []);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return \Yii::t('app', 'Место проведения мероприятия на карте');
    }

    /**
     * @return string
     */
    public function getPosition()
    {
        return \event\components\WidgetPosition::Sidebar;
    }
}
