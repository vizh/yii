<?php
namespace competence\models\test\runet2016;

class D2_7 extends D2
{
    protected $baseCodeMarket = 'B1_2';

    protected $lastCode = 'E1_2';

    protected $nextCodes = ['8'=>'C1_8'];

    public $subMarkets = [
        '1' => 'Доля мобильных пользователей SaaS',
        '2' => 'Доля продаж мобильных приложений SaaS'
    ];
}
