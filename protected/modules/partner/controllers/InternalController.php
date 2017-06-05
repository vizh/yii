<?php

class InternalController extends \partner\components\Controller
{
    public function actions()
    {
        return [
            'hl12badgefix' => '\partner\controllers\internal\Hl12badgefixAction',
            'hl12badgeinfo' => '\partner\controllers\internal\Hl12badgeinfoAction',
            'tc12import' => '\partner\controllers\internal\Tc12importAction',
            'tc12option' => '\partner\controllers\internal\Tc12optionAction',
            'safor13import' => '\partner\controllers\internal\Safor13importAction',
            'eaapa2013import' => '\partner\controllers\internal\Eaapa2013importAction',
            'icomf13addproduct' => '\partner\controllers\internal\Icomf13addproductAction',
            'techmailru13import' => '\partner\controllers\internal\Techmailru13importAction',
            'snce13import' => '\partner\controllers\internal\import\Snce13Action',
            'ritconf13import' => '\partner\controllers\internal\import\Ritconf13Action',
            'telekom13import' => '\partner\controllers\internal\import\Telekom13Action',
            'rifvrn13import' => '\partner\controllers\internal\Rifvrn13importAction',
            'mipacademy13import' => '\partner\controllers\internal\import\Mipacademy13Action',
            'phdays13import' => '\partner\controllers\internal\import\Phdays13Action',
            'phdaysoption' => '\partner\controllers\internal\PhdaysoptionAction',
            'demo13import' => '\partner\controllers\internal\import\Demo13Action',
            'rgw13import' => '\partner\controllers\internal\import\Rgw13Action'

        ];
    }
}
