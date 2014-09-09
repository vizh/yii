<?php
namespace competence\models\test\runet2014;

class C8_12 extends C8 {
    protected $baseCode = 'B4_12';

    protected $nextCodeToCompany = 'C9_12';

    public $subMarkets = [
        '12_1' => 'Билеты (транспорт)',
        '12_2' => 'Туры',
        '12_3' => 'Прочие туристические услуги'
    ];

    protected $nextCodeToComment = 'C10A_12';
}
