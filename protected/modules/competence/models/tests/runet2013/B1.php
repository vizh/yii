<?php
namespace competence\models\tests\runet2013;

class B1 extends \competence\models\Question
{
  public function getOptions()
  {
    return [
      1 => ['Маркетинг и реклама', 'Включает рынки Веб-разработки, контекстной рекламы, медийной рекламы, видеорекламы, маркетинга в социальных медиа (SMM), поисковой оптимизации'],
      2 => ['Инфраструктура', 'Включает рынки программного обеспечения как услуги (SaaS), хостинга и доменов'],
      3 => ['Электронная коммерция', 'Включает рынки ретейла, электронных платежей, контента и туризма'],
      4 => ['Игры', ''],
      5 => ['Работа и образование', '']
    ];
  }
  
  public function getPrev()
  {
    return new A7($this->test);
  }
  
  public function getNext()
  {
    if ($this->value == 4)
    {
      $b2 = new B2($this->test);
      $b2->value[] = 14;
      $b2->parse();
      return new B3_14($this->test);
    }
    return new B2($this->test);
  }
  
  public function rules()
  {
    return [
      ['value', 'required', 'message' => 'Выберите однин из сегментов интернет-индустрии']
    ];
  }
}
