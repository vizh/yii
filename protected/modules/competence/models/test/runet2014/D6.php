<?php
namespace competence\models\test\runet2014;

class D6 extends D
{
    private $values = null;
    public function getValues()
    {
        if ($this->values == null) {
            $this->values = ['' => '-'];
            $this->values[1] = 'Изменения произошли';
            $this->values[2] = 'Изменения не произошли, но планируются';
            $this->values[3] = "Изменения не произошли и не планируются";
            $this->values[4] = 'Затрудняюсь ответитьсуждениях не участвовали';
        }
        return $this->values;
    }
}
