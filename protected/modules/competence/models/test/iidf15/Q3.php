<?php
namespace competence\models\test\iidf15;

class Q3 extends \competence\models\form\Single
{
    /**
     * @return string
     * @throws \application\components\Exception
     */
    protected function getDefinedViewPath()
    {
        return 'competence.views.test.' . $this->getQuestion()->getTest()->Code . '.q3';
    }
}
