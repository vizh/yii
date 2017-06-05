<?php
namespace ruvents\controllers\event;

use event\models\Part;

/**
 * @deprecated
 */
class PartsAction extends \ruvents\components\Action
{
    public function run()
    {
        $parts = Part::model()
            ->byEventId($this->getEvent()->Id)
            ->findAll();

        $response = [];

        foreach ($parts as $part) {
            $response[] = $this->getDataBuilder()->createPart($part);
        }

        $this->renderJson([
            'Parts' => $response
        ]);
    }
}
