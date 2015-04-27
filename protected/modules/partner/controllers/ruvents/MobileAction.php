<?php
namespace partner\controllers\ruvents;

use \ruvents\models\Account;
use \application\components\utility\Texts;

class MobileAction extends \partner\components\Action
{
    public function run()
    {
        $account = Account::model()->byEventId($this->getEvent()->Id)->find();
        if ($account == null) {
            $account = new Account();
            $account->EventId = $this->getEvent()->Id;
            $account->Hash = Texts::GenerateString(25);
            $account->save();
        }

        $data = 'SYS:ACCOUNT:' . $account->Hash;
        $size = 200;
        $googleChartApiUrl = 'http://chart.apis.google.com/chart?cht=qr&chs='.$size.'x'.$size.'&chl='.urlencode($data);
        $qrCode = file_get_contents($googleChartApiUrl);
        header('Content-type: image/png');
        echo $qrCode;
    }
} 