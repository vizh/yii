<?php
namespace event\widgets\tabs;

class CustomAbout extends \event\widgets\About
{
    public function run()
    {
        $this->render('customabout/'.$this->event->IdName, []);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return \Yii::t('app', 'Полное описание');
    }
}
