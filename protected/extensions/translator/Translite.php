<?php
class Translite
{
  protected function getAvailableLocales()
  {
    return array('ru', 'en');
  }

  private $table_ru_en = array(
    'а' => 'a', 'б' => 'b', 'в' => 'v',
    'г' => 'g', 'д' => 'd', 'е' => 'e',
    'ё' => 'e', 'ж' => 'zh', 'з' => 'z',
    'и' => 'i', 'й' => 'y', 'к' => 'k',
    'л' => 'l', 'м' => 'm', 'н' => 'n',
    'о' => 'o', 'п' => 'p', 'р' => 'r',
    'с' => 's', 'т' => 't', 'у' => 'u',
    'ф' => 'f', 'х' => 'h', 'ц' => 'c',
    'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
    'ь' => '\'', 'ы' => 'y', 'ъ' => '\'',
    'э' => 'e', 'ю' => 'yu', 'я' => 'ya',

    'А' => 'A', 'Б' => 'B', 'В' => 'V',
    'Г' => 'G', 'Д' => 'D', 'Е' => 'E',
    'Ё' => 'E', 'Ж' => 'Zh', 'З' => 'Z',
    'И' => 'I', 'Й' => 'Y', 'К' => 'K',
    'Л' => 'L', 'М' => 'M', 'Н' => 'N',
    'О' => 'O', 'П' => 'P', 'Р' => 'R',
    'С' => 'S', 'Т' => 'T', 'У' => 'U',
    'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
    'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sch',
    'Ь' => '\'', 'Ы' => 'Y', 'Ъ' => '\'',
    'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
  );
  private $table_en_ru = array(
    'et' => 'эт',
    'Et' => 'Эт',
    'ep' => 'эп',
    'Ep' => 'Эп',
    'Ye' => 'Е',
    'ye' => 'е',
    'ey' => 'й',
    'e' => 'e',
    'E' => 'Е',

    'j' => 'дж',
    'q' => 'к',
    'w' => 'в',
    'x' => 'кс',
    'J' => 'Дж',
    'Q' => 'К',
    'W' => 'В',
    'X' => 'Кс',
  );


  public function __construct()
  {
    $this->table_en_ru = $this->table_en_ru + array_flip($this->table_ru_en);
  }

  public function translit($text, $inLocale = 'ru', $outLocale = 'en')
  {
    if (!in_array($inLocale, $this->getAvailableLocales()))
    {
      throw new \Exception('In locale "'.$inLocale.'" is not supported!');
    }

    if (!in_array($outLocale, $this->getAvailableLocales()))
    {
      throw new \Exception('Out locale "'.$outLocale.'" is not supported!');
    }

    return strtr($text, $this->{'table_'.$inLocale.'_'.$outLocale});
  }

  /**
* Возращает локаль по тексту
* @param string $text
* @return string
*/
  public function getLocale($text)
  {
    $locales = $this->getAvailableLocales();
    foreach ($locales as $key => $locale)
    {
      $table = $this->{'table_'.$locale.'_'.($key == 0 ? $locales[1] : $locales[$key-1])};
      $key = mb_substr($text, 0, 1, 'utf-8');
      if (isset($table[$key]))
      {
        return $locale;
      }
    }
    return 'en';
    //todo: Продумать, что возвращать, в случае не возможности определить локаль.
    throw new Exception('Не удалось определить локаль для транслитерации: ' . $text);
  }
}