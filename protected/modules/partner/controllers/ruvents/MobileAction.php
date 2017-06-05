<?php
namespace partner\controllers\ruvents;

use partner\components\Action;

class MobileAction extends Action
{
    public function run()
    {
        $data = 'SYS:ACCOUNT:'.$this->getRuventsAccount()->Hash;
        $size = 200;
        $googleChartApiUrl = 'http://chart.apis.google.com/chart?cht=qr&chs='.$size.'x'.$size.'&chl='.urlencode($data);
        $qrCode = file_get_contents($googleChartApiUrl);
        header('Content-type: image/png');
        echo $qrCode;
    }
} 