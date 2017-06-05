<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 12.10.2015
 * Time: 15:12
 */

namespace event\components\tickets;

class Premiaru15 extends Ticket
{
    /** @inheritdoc */
    protected function createPdf()
    {
        $this->pdf = new \mPDF('', 'A4-L', 0, '', 0, 0, 0, 0, 0, 0, 'L');
        $this->pdf->WriteHTML($this->getHtml());
        $this->pdf->bodyBackgroundColor = '#000000';
    }
}