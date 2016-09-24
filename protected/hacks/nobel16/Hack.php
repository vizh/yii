<?php
/**
 * Created by IntelliJ IDEA.
 * User: opcode
 * Date: 24/09/16
 * Time: 01:09
 */

namespace application\hacks\nobel16;

use application\hacks\AbstractHack;

class Hack extends AbstractHack
{
    public function onPartnerMenuBuild(array $items)
    {
        foreach ($items as &$item) {
            if ($item['label'] === 'Статистика') {
                $item['items'][] = [
                    'label' => 'Прикладывания CSV',
                    'url' => ['main/nobel16']
                ];
                break;
            }
        }

        return $items;
    }

    public function onPartnerRegisterControllerActions(array $actions)
    {
        return array_merge($actions, [
            'nobel16' => 'application\hacks\nobel16\actions\Nobel16Action'
        ]);
    }
}