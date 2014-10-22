<?php
namespace pay\controllers\admin\coupon;


use event\models\Participant;
use pay\models\Coupon;

class MultipleAction extends \CAction
{
    public function run()
    {
        $coupon = Coupon::model()->byCode('PM14_25')->find();

        $c = 0;

        $paricipants = Participant::model()->byEventId(1315)->byRoleId(1)->findAll();
        foreach ($paricipants as $participant) {
            if (!Participant::model()->byEventId(889)->byRoleId(11)->byUserId($participant->UserId)->exists()) {
                try {
                    $coupon->activate($participant->User, $participant->User);
                } catch (\Exception $e) {
                    echo $e->getMessage().'<br/>';
                }
            }
        }
    }
} 