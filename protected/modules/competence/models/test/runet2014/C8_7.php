<?php
namespace competence\models\test\runet2014;

class C8_7 extends C8 {
    protected $baseCode = 'B4_7';

    protected $nextCodeToCompany = 'C9_7';

    public $subMarkets = [
        '7_1' => 'Физические товары, включая продукты питания',
        '7_2' => 'Купоны',
        '7_3' => 'Билеты (мероприятия)',
        '7_4' => 'Бытовые услуги и медицина'
    ];

    protected $nextCodeToComment = 'C10A_7';
}
