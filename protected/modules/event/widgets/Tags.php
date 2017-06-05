<?php
namespace event\widgets;

class Tags extends \event\components\Widget
{

    public function run()
    {
        $this->render('tags', []);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return \Yii::t('app', 'Теги мероприятия');
    }

    /**
     * @return string
     */
    public function getPosition()
    {
        return \event\components\WidgetPosition::Sidebar;
    }
}
