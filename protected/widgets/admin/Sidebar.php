<?php
namespace application\widgets\admin;

use event\models\Event;

class Sidebar extends \CWidget
{
    public function run()
    {
        $counts = new \stdClass();
        $counts->Event = Event::model()
            ->byExternal()
            ->byApproved(false)
            ->byDeleted(false)
            ->count();

        $this->render('sidebar', [
            'counts' => $counts
        ]);
    }
}
