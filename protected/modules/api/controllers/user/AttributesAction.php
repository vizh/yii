<?php

namespace api\controllers\user;

use api\components\Action;
use api\components\Exception;

/**
 * Class AttributesAction
 */
class AttributesAction extends Action
{
    /**
     * @throws Exception
     */
    public function run()
    {
        if ($this->getEvent()->IdName !== 'svyaz16') {
            throw new Exception(104);
        }

        $this->setResult([
            'q1' => 'Какие выставки кроме Связь-2016, одновременно проходящие на ЦВК Экспоцентр, Вы планируете посетить?',
            'q2' => 'Вы посещаете выставку Связь-2016 по профессиональным интересам или по личным?',
            'q3' => 'Заинтересован принять участие в выставке в качестве экспонента',
        ]);
    }
} 
