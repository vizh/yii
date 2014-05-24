<?php
namespace partner\controllers\ruvents;

use ruvents\models\AccountRole;

class MobileAction extends \partner\components\Action
{
    public function run()
    {
        $account = \ruvents\models\Account::model()
            ->byEventId($this->getEvent()->Id)->byRole(AccountRole::MOBILE)->find();
        if ($account == null)
        {
            $account = new \ruvents\models\Account();
            $account->EventId = $this->getEvent()->Id;
            $account->Hash = \application\components\utility\Texts::GenerateString(25);
            $account->Role = AccountRole::MOBILE;
            $account->save();
        }

        $data = 'SYS:ACCOUNT:'.$account->Hash;
        $size = 200;
        $googleChartApiUrl = 'http://chart.apis.google.com/chart?cht=qr&chs='.$size.'x'.$size.'&chl='.urlencode($data);
        $qrCode = file_get_contents($googleChartApiUrl);
        header('Content-type: image/png');
        echo $qrCode;
    }
} 