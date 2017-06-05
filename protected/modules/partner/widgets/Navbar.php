<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 15.06.2015
 * Time: 13:37
 */

namespace partner\widgets;

use event\models\Event;

class Navbar extends \CWidget
{
    /** @var Event */
    public $event;

    public function run()
    {
        $user = \Yii::app()->getUser();

        if (!$user->getIsGuest() && \Yii::app()->partner->getIsSetEvent()) {
            $event = \Yii::app()->partner->getEvent();
            return $this->render('navbar', [
                'user' => $user->getCurrentUser(),
                'event' => $event
            ]);
        }
    }

} 