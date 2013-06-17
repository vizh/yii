<?php
namespace competence\models\tests\mailru2013;

class A2 extends \competence\models\Question
{

  private $options = null;
  public function getOptions()
  {
    if ($this->options === null)
    {
      $this->options = $this->rotate('A2_opt', [
        39 => 'Волож (<em>Яндекс</em>)',
        40 => 'Гришин (<em>Mail.Ru&nbsp;Group</em>)',
        41 => 'Дуров (<em>ВКонтакте</em>)',
        42 => 'Молибог (<em>Rambler</em>)',
        43 => 'Пейдж (<em>Google&nbsp;Global</em>)',
        44 => 'Цукерберг (<em>Facebook</em>)',
        45 => 'Балмер (<em>Microsoft</em>)',
        46 => 'Касперский (<em>Касперский</em>)',
        47 => 'Белоусов (<em>Parallels</em>)',
        48 => 'Долгов (<em>ex-Google&nbsp;Russia</em>)',
        400 => 'Широков (<em>Одноклассники</em>)',
        401 => 'Артамонова (<em>Mail.ru Group</em>)',
        390 => 'Сегалович (<em>Яндекс</em>)'
      ]);
    }
    return $this->options;
  }

  public function rules()
  {
    return [
      ['value', 'checkAllValidator']
    ];
  }

  public function checkAllValidator($attribute, $params)
  {
    $fullData = $this->getFullData();
    $base = new A1($this->test);
    $baseData = $fullData[get_class($base)];
    foreach ($baseData['value'] as $key => $value)
    {
      if ((empty($this->value[$key]['Company']) && empty($this->value[$key]['CompanyEmpty'])) || (empty($this->value[$key]['LastName']) && empty($this->value[$key]['LastNameEmpty'])))
      {
        $this->addError('value', 'Необходимо заполнить все значения фамилии и компании, или отметить вариант "затрудняюсь ответить".');
        return false;
      }
    }
    return true;
  }

  /**
   * @return \competence\models\Question
   */
  public function getNext()
  {
    return new A4($this->test);
  }

  /**
   * @return \competence\models\Question
   */
  public function getPrev()
  {
    $fullData = $this->getFullData();
    $prev = new E5($this->test);
    if (isset($fullData[get_class($prev)]))
    {
      return $prev;
    }
    $prev = new E1_1($this->test);
    if (isset($fullData[get_class($prev)]))
    {
      return $prev;
    }
    return new E1($this->test);
  }

  public function getNumber()
  {
    return 10;
  }
}