<?php
namespace event\widgets\header;

class Custom extends Header
{
    public function run()
    {
        $this->render('custom/'.$this->event->IdName, []);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return \Yii::t('app', 'Кастомизированная шапка мероприятия');
    }
}
