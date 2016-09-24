<?php

namespace application\hacks;

use event\models\Event;

class AbstractHack
{
    /**
     * @param Event|null $event
     * @return AbstractHack
     */
    public static function getByEvent($event)
    {
        /** @var AbstractHack $hack */
        static $hack;

        if ($hack === null) {
            $hack = $event !== null && file_exists(sprintf('%s/%s/Hack.php', __DIR__, $event->IdName)) && class_exists($definition = "\\application\\hacks\\{$event->IdName}\\Hack")
                ? new $definition
                : new self();

            $hack->init();
        }

        return $hack;
    }

    public function init()
    {

    }

    public function onPartnerMenuBuild(array $items)
    {
        return $items;
    }

    public function onPartnerRegisterControllerActions(array $actions)
    {
        return $actions;
    }
}