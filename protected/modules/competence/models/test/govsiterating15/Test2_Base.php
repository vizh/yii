<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 14.05.2015
 * Time: 12:09
 */

namespace competence\models\test\govsiterating15;


use competence\models\form\Single;

class Test2_Base extends Single
{
    public function getTitle()
    {
        $site = Proxy::getRateSite();
        $title  = '
            Посетите сайт "<a href="'. $site[1] .'" target="_blank">'. $site[0] .'</a>". Ознакомьтесь с его содержанием.
            <div class="row m-top_10 m-bottom_60">
                <div class="text-center span8">
                    <a class="btn" style="font-weight: normal;" href="http://www.fas.gov.ru" target="_blank">ПЕРЕЙТИ НА САЙТ ФОИВ</a>
                </div>
            </div>
        ';
        $title .= parent::getTitle();
        return $title;
    }
} 