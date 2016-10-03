<?php
namespace application\widgets;


use application\components\web\Widget;

class Banner940 extends Widget
{
    private $banners = [
        //['/images/banners/940x250_topevents15.jpg', 'http://events.runet-id.com/', 'RUNET—ID рукомендует. Главные мероприятия 2015 года'],
//        ['/images/banners/940x250_croud-iri.jpg', 'http://experts.iri.center/', 'КРАУДСОРСИНГОВАЯ ПЛАТФОРМА ИРИ']
//        ['/images/banners/940x300_EconomyRunet16.jpg', 'https://runet-id.com/event/presentation-research2016/', 'Исследование «Экономика Рунета 2015-2016»']
    ];

    public function run()
    {
        if (empty($this->banners)) {
            return;
        }

        $i = rand(0, sizeof($this->banners)-1);
        $banner = $this->banners[$i];
        echo \CHtml::link(
            \CHtml::image($banner[0], $banner[2], ['style' => 'height: auto; width: 100%;']),
            $banner[1],
            ['target' => '_blank']
        );
    }
}