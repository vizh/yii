<?php
namespace competence\models\test\mailru2014_prof;

class A4 extends \competence\models\form\Base {

    public $value = [];

    private $options = null;
    public function getOptions()
    {
        if ($this->options === null)
        {
            $this->options = $this->rotate('A4_opt', [
                39 => '<strong>Волож</strong> (<em>Яндекс</em>)',
                40 => '<strong>Гришин</strong> (<em>Mail.Ru&nbsp;Group</em>)',
                41 => '<strong>Дуров</strong> (<em>ex ВКонтакте</em>)',
                403 => '<strong>Рогозов</strong> (<em>ВКонтакте</em>)',
                404 => '<strong>Доброеев</strong> (<em>ВКонтакте</em>)',
                405 => '<strong>Сергеев Дм.</strong> (<em>ВКонтакте</em>)',
                42 => '<strong>Молибог</strong> (<em>РБК</em>)',
                43 => '<strong>Пейдж</strong> (<em>Google&nbsp;Global</em>)',
                44 => '<strong>Цукерберг</strong> (<em>Facebook</em>)',
                45 => '<strong>Балмер</strong> (<em>ex Microsoft</em>)',
                406 => '<strong>Сатья Наделла</strong> (<em>Microsoft</em>)',
                46 => '<strong>Касперский</strong> (<em>Касперский</em>)',
                47 => '<strong>Белоусов</strong> (<em>Parallels</em>)',
                408 => '<strong>Соловьева</strong> (<em>Google Россия</em>)',
                48 => '<strong>Долгов</strong> (<em>eBay</em>)',
                407 => '<strong>Антон Федчин</strong> (<em>Одноклассники</em>)',
                400 => '<strong>Широков</strong> (<em>Mail.Ru Group, ex Одноклассники</em>)',
                401 => '<strong>Артамонова</strong> (<em>Mail.ru Group</em>)'
            ]);
        }
        return $this->options;
    }

    public function rules()
    {
        return [
            ['value', 'required', 'message' => 'Отметьте, о ком вы слышали, или выберите вариант затрудняюсь ответить.']
        ];
    }

    public function getPrev()
    {
        $e1 = $this->getQuestionByCode('E1');
        if (in_array(99, $e1->getResult()['value']))
        {
            return $e1;
        }
        else
        {
            $e1_1 = $this->getQuestionByCode('E1_1');
            if (in_array(99, $e1_1->getResult()['value']))
            {
                return $e1_1;
            }
        }
        return parent::getPrev();
    }


    public function getNext()
    {
        if (in_array(99, $this->value))
        {
            return $this->getQuestionByCode('A6');
        }
        return parent::getNext();
    }
}
