<?php
namespace competence\models\test\runet2016;

class D2_1 extends D2
{
    protected $baseCodeMarket = 'B1_1';

    protected $lastCode = 'E1_1';

    protected $nextCodes = ['2_1'=>'C1_2_1', '2_2'=>'C1_2_2', '3_1'=>'C1_3_1', '3_2'=>'C1_3_2', '4'=>'C1_4'];

    public $subMarkets = [
        '1' => 'Доля мобильных (адаптивных) версий сайтов и приложений в количестве заказов',
        '2' => 'Доля мобильных (адаптивных) версий сайтов и приложений в обороте компаний сегмента'
    ];
}
