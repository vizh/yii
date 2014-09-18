<?php
namespace competence\models\test\runet2014;

class D6 extends D
{
    private $values = null;
    public function getValues()
    {
        if ($this->values == null) {
            $this->values = ['' => '-'];
            $this->values[1] = 'Изменения были произведены или в процессе';
            $this->values[2] = 'Изменения не были произведены, но планируются';
            $this->values[3] = 'Изменения не были произведены и не планируются';
            $this->values[4] = 'Затрудняюсь ответить';
        }
        return $this->values;
    }
}
