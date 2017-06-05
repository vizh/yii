<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 12.10.2015
 * Time: 15:12
 */

namespace event\components\tickets;

class Edcrunch15 extends Ticket
{
    /** @inheritdoc */
    protected function createPdf()
    {
        $this->pdf = new \mPDF('', 'A4', 0, \Yii::getPathOfAlias('webroot.img.ticket.edcrunch15').DIRECTORY_SEPARATOR.'FontfabricGloberBold.ttf', 5, 5, 5, 5);
        $this->pdf->WriteHTML($this->getHtml());
    }
}