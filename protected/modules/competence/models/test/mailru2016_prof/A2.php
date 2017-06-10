<?php
namespace competence\models\test\mailru2016_prof;

use competence\models\Result;

class A2 extends \competence\models\form\Base {
  protected function getBaseQuestionCode()
  {
    return 'A1';
  }

  protected $options;

  public function getOptions()
  {
    if ($this->options == null)
    {
      /** @var A1 $form */
      $form = $this->getBaseQuestion()->getForm();
      $result = $this->getBaseQuestion()->getResult();
      if ($result !== null)
      {
        $this->options = [];
        foreach ($form->getOptions() as $key => $value)
        {
          if (isset($result['value'][$key]))
          {
            $this->options[$key] = $value;
          }
        }
      }
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
    foreach ($this->getOptions() as $key => $value)
    {
      if ((empty($this->value[$key]['Company']) && empty($this->value[$key]['CompanyEmpty'])) || (empty($this->value[$key]['LastName']) && empty($this->value[$key]['LastNameEmpty'])))
      {
        $this->addError('value', 'Необходимо заполнить все значения фамилии и компании, или отметить вариант "затрудняюсь ответить".');
        return false;
      }
    }
    return true;
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

    protected function getInternalExportValueTitles()
    {
        $titles = [
            'Гришин (Mail.Ru&nbsp;Group) - Фамилия',              'Гришин (Mail.Ru&nbsp;Group) - Компания',
            'Дуров (Telegram) - Фамилия',                         'Дуров (Telegram) - Компания',
            'Молибог (РБК) - Фамилия',                            'Молибог (РБК) - Компания',
            'Пейдж (Alphabet, Google Global) - Фамилия',          'Пейдж (Alphabet, Google Global) - Компания',
            'Цукерберг (Facebook) - Фамилия',                     'Цукерберг (Facebook) - Компания',
            'Касперский (Касперский) - Фамилия',                  'Касперский (Касперский) - Компания',
            'Белоусов (Acronis, Parallels) - Фамилия',            'Белоусов (Acronis, Parallels) - Компания',
            'Долгов (eBay) - Фамилия',                            'Долгов (eBay) - Компания',
            'Артамонова Анна (Mail.Ru Group) - Фамилия',          'Артамонова Анна (Mail.Ru Group) - Компания',
            'Рогозов (ВКонтакте) - Фамилия',                      'Рогозов (ВКонтакте) - Компания',
            'Добродеев (Mail.Ru Group, ВКонтакте) - Фамилия',     'Добродеев (Mail.Ru Group, ВКонтакте) - Компания',
            'Сергеев Дмитрий (Mail.Ru Group) - Фамилия',          'Сергеев Дмитрий (Mail.Ru Group) - Компания',
            'Сатья Наделла (Microsoft) - Фамилия',                'Сатья Наделла (Microsoft) - Компания',
            'Федчин (Одноклассники) - Фамилия',                   'Федчин (Одноклассники) - Компания',
            'Соловьева (Google Россия) - Фамилия',                'Соловьева (Google Россия) - Компания',
            'Шульгин (Яндекс) - Фамилия',                         'Шульгин (Яндекс) - Компания',
            'Волож (Яндекс) - Фамилия',                           'Волож (Яндекс) - Компания',
            'Касперская (InfoWatch) - Фамилия',                   'Касперская (InfoWatch) - Компания',
            'Брин (Google) - Фамилия',                            'Брин (Google) - Компания',
            'Ян (ABBY) - Фамилия',                                'Ян (ABBY) - Компания',
        ];
        return $titles;
    }

    protected function getInternalExportData(Result $result)
    {
        $titles = [
            40, 41, 42, 43, 44, 46, 47, 48, 401, 403, 404, 405, 406, 407, 408, 409, 410, 411, 412, 413
        ];
        $questionData = $result->getQuestionResult($this->question);
        $data = [];
        foreach ($titles as $key) {
            if (isset($questionData['value'][$key]['LastName'])) {
                $data[] = $questionData['value'][$key]['LastName'];
            } elseif (isset($questionData['value'][$key]['LastNameEmpty'])) {
                $data[] = 'не знаю';
            } else {
                $data[] = '';
            }

            if (isset($questionData['value'][$key]['Company'])) {
                $data[] = $questionData['value'][$key]['Company'];
            } elseif (isset($questionData['value'][$key]['CompanyEmpty'])) {
                $data[] = 'не знаю';
            } else {
                $data[] = '';
            }
        }
        return $data;
    }
}
