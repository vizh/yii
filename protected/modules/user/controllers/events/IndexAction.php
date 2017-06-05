<?php
namespace user\controllers\events;

use event\models\Participant;
use event\models\Role;

class IndexAction extends \CAction
{
    public function run()
    {
        $user = \Yii::app()->user->getCurrentUser();
        $events = Participant::model()->byUserId($user->Id)->findAll();

        $curDate = strtotime(date('Ymd'));
        $pastEvents = $futureEvents = [];
        $i = $j = 0;
        foreach ($events as $event):
            if ($event->Event->Visible):
                strlen($event->Event->StartMonth) == 1 ? $event->Event->StartMonth = '0'.$event->Event->StartMonth : '';
                strlen($event->Event->StartDay) == 1 ? $event->Event->StartDay = '0'.$event->Event->StartDay : '';
                $eventDate = $event->Event->StartYear.$event->Event->StartMonth.$event->Event->StartDay;
                $eventDateTime = strtotime($eventDate);
                if ($eventDateTime < $curDate):
                    if ($event->RoleId != Role::VIRTUAL_ROLE_ID):
                        $pastEvents[$i]['Event'] = $event;
                        $pastEvents[$i]['Date'] = $eventDate;
                        $i++;
                    endif;
                else:
                    if ($event->RoleId != Role::VIRTUAL_ROLE_ID):
                        $futureEvents[$j]['Event'] = $event;
                        $futureEvents[$j]['Date'] = $eventDate;
                        $j++;
                    endif;
                endif;
            endif;
        endforeach;
        $pastEvents = $this->sortEvents($pastEvents);
        $futureEvents = $this->sortEvents($futureEvents);
        $this->getController()->render('index', ['pastEvents' => $pastEvents, 'futureEvents' => $futureEvents]);
    }

    /**
     * Сортировка событий по дате
     * @param array
     * @return array
     */

    public function sortEvents($eventsArray)
    {
        $array = [];
        foreach ($eventsArray as $event) {
            $array[$event['Date']] = $event['Event'];
        }
        array_multisort($array, SORT_DESC);
        return $array;
    }
}