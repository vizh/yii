<?php
namespace competence\models\test\runet2014;

class D3 extends D
{
    private $values = null;
    public function getValues()
    {
        if ($this->values == null) {
            $this->values = ['' => '-'];
            $this->values[1] = 'Приходилось участвовать лично';
            $this->values[2] = 'Лично не участвовал, однако мне известно, что в таких обсуждениях участвовали другие сотрудники моей организации';
            $this->values[3] = "Лично не участвовал, об участии в обсуждении других сотрудников моей организации мне неизвестно";
            $this->values[4] = 'Ни я лично, ни другие сотрудники моей организации в таких обсуждениях не участвовали';
        }
        return $this->values;
    }
}
