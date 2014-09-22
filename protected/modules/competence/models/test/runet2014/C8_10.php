<?php
namespace competence\models\test\runet2014;

class C8_10 extends C8 {
    protected $baseCode = 'B4_10';

    protected $nextCodeToCompany = 'C9_10';

    public $subMarkets = [
        '10_1' => 'Физические товары, включая продукты питания',
        '10_2' => 'Купоны',
        '10_3' => 'Билеты (мероприятия)',
        '10_4' => 'Бытовые услуги и медицина',
    ];

    protected $nextCodeToComment = 'C10A_10';
}
