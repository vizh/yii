<?php
namespace api\controllers\connect;

use application\components\helpers\ArrayHelper;
use connect\models\Meeting;

class ListAction extends \api\components\Action
{
    public function run()
    {
        $meetings = Meeting::model()
            ->with('UserLinks');

        if ($this->hasRequestParam('RunetId')) {
            $meetings->byCreatorId($this->getRequestedUser()->Id);
        }

        if ($this->hasRequestParam('Type')){
            $meetings->byType($this->getRequestParam('Type'));
        }

        $meetings = $meetings->findAll();

        $result = [];
        foreach ($meetings as $meeting) {
            $result[] = $this
                ->getDataBuilder()
                ->createMeeting($meeting);
        }

        ArrayHelper::multisort($result, 'UserCount', SORT_DESC);

        $this->setResult(['Success' => true, 'Meetings' => $result]);
    }
}