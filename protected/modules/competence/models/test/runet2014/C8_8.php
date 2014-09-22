<?php
namespace competence\models\test\runet2014;

class C8_8 extends C8 {
    protected $baseCode = 'B4_8';

    protected $nextCodeToCompany = 'C9_8';

    public $subMarkets = [
        '8_1' => 'Хостинг (кроме облачного)',
        '8_2' => 'Облачный хостинг'
    ];

    protected $nextCodeToComment = 'C10A_8';
}
