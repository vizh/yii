<?php
namespace competence\models\test\devcon15;

class Q3 extends MultipleSomeOther
{
    public $other_2;
    public $other_3;
    public $other_8;

    /**
     * @return array
     */
    protected function getFormData()
    {
        return [
            'value' => $this->value,
            'other_2' => $this->other_2,
            'other_3' => $this->other_3,
            'other_8' => $this->other_8
        ];
    }
}
