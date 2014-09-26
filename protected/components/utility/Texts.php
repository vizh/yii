<?php
namespace application\components\utility;

class Texts
{

    private static $iso9_table = array(
        'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Ѓ' => 'G`',
        'Ґ' => 'G`', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'YO', 'Є' => 'YE',
        'Ж' => 'ZH', 'З' => 'Z', 'Ѕ' => 'Z', 'И' => 'I', 'Й' => 'Y',
        'Ј' => 'J', 'І' => 'I', 'Ї' => 'YI', 'К' => 'K', 'Ќ' => 'K',
        'Л' => 'L', 'Љ' => 'L', 'М' => 'M', 'Н' => 'N', 'Њ' => 'N',
        'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T',
        'У' => 'U', 'Ў' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'TS',
        'Ч' => 'CH', 'Џ' => 'DH', 'Ш' => 'SH', 'Щ' => 'SHH', 'Ъ' => '``',
        'Ы' => 'YI', 'Ь' => '`', 'Э' => 'E`', 'Ю' => 'YU', 'Я' => 'YA',
        'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'ѓ' => 'g',
        'ґ' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'є' => 'ye',
        'ж' => 'zh', 'з' => 'z', 'ѕ' => 'z', 'и' => 'i', 'й' => 'y',
        'ј' => 'j', 'і' => 'i', 'ї' => 'yi', 'к' => 'k', 'ќ' => 'k',
        'л' => 'l', 'љ' => 'l', 'м' => 'm', 'н' => 'n', 'њ' => 'n',
        'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
        'у' => 'u', 'ў' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'ts',
        'ч' => 'ch', 'џ' => 'dh', 'ш' => 'sh', 'щ' => 'shh', 'ь' => '',
        'ы' => 'yi', 'ъ' => "'", 'э' => 'e`', 'ю' => 'yu', 'я' => 'ya'
    );

    public static function CyrToLat($string)
    {
        return strtr($string, self::$iso9_table);
    }

    public static function CyrToLatTitle($title)
    {
        $title = mb_strtolower($title, 'utf-8');
        $title = self::CyrToLat($title);
        $title = preg_replace("/[^A-Za-z0-9`'_\-\.]/", '-', $title);
        $title = preg_replace('/-+/', '-', $title);
        $title = trim($title, '-');
        return $title;
    }


    public static function GeneratePassword($length = 8)
    {
        $base = md5(uniqid(rand(), true));
        $length = min(strlen($base), $length);
        return substr($base, 0, $length);
    }

    public static function GenerateString($length, $onlyLowCase = false)
    {
        $chars = 'abdefhiknrstyz23456789';
        if (!$onlyLowCase)
            $chars .= 'ABDEFGHKNQRSTYZ';
        $numChars = strlen($chars);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, mt_rand(1, $numChars) - 1, 1);
        }
        return $string;
    }

    public static function cropText($content, $maxLength)
    {
        if (mb_strlen($content, 'utf8') > $maxLength)
        {
            $parts = preg_split('/([\.!?;])/is', $content, -1, PREG_SPLIT_DELIM_CAPTURE|PREG_SPLIT_NO_EMPTY);
            $content = '';
            foreach($parts as $part)
            {
                if (mb_strlen($content . $part, 'utf8') > $maxLength && mb_strlen($part) != 1)
                {
                    if (mb_strlen($content, 'utf8') > 0)
                    {
                        return $content;
                    }
                    else
                    {
                        return mb_substr($content.$part, 0, $maxLength, 'utf8').'...';
                    }
                }
                $content .= $part;
            }
        }
        return $content;
    }

    /**
     * Сумма прописью
     * @author runcore
     * @param float $inn
     * @param bool $stripkop
     * @return string
     */
    public static function NumberToText($inn, $stripkop=false) {
        $nol = 'ноль';
        $str[100]= array('','Сто','Двести','Триста','Четыреста','Пятьсот','Шестьсот', 'Семьсот', 'Восемьсот','Девятьсот');
        $str[11] = array('','Десять','Одиннадцать','Двенадцать','Тринадцать', 'Четырнадцать','Пятнадцать','Шестнадцать','Семнадцать', 'Восемнадцать','Девятнадцать','Двадцать');
        $str[10] = array('','Десять','Двадцать','Тридцать','Сорок','Пятьдесят', 'Шестьдесят','Семьдесят','Восемьдесят','Девяносто');
        $sex = array(
            array('','Один','Два','Три','Четыре','Пять','Шесть','Семь', 'Восемь','Девять'),// m
            array('','Одна','Две','Три','Четыре','Пять','Шесть','Семь', 'Восемь','Девять') // f
        );
        $forms = array(
            array('копейка', 'копейки', 'копеек', 1), // 10^-2
            //array('рубль', 'рубля', 'рублей',  0), // 10^ 0
            array('', '', '', 0),//todo: модификация метода, чтобы не выводить фразу "рублей"
            array('тысяча', 'тысячи', 'тысяч', 1), // 10^ 3
            array('миллион', 'миллиона', 'миллионов',  0), // 10^ 6
            array('миллиард', 'миллиарда', 'миллиардов',  0), // 10^ 9
            array('триллион', 'триллиона', 'триллионов',  0), // 10^12
        );
        $out = $tmp = array();
        // Поехали!
        $tmp = explode('.', str_replace(',','.', $inn));
        $rub = number_format($tmp[0], 0,'','-');
        if ($rub== 0) $out[] = $nol;
        // нормализация копеек
        $kop = isset($tmp[1]) ? substr(str_pad($tmp[1], 2, '0', STR_PAD_RIGHT), 0,2) : '00';
        $segments = explode('-', $rub);
        $offset = sizeof($segments);
        if ((int)$rub== 0) { // если 0 рублей
            $o[] = $nol;
            $o[] = self::morph( 0, $forms[1][ 0],$forms[1][1],$forms[1][2]);
        }
        else {
            foreach ($segments as $k=>$lev) {
                $sexi= (int) $forms[$offset][3]; // определяем род
                $ri = (int) $lev; // текущий сегмент
                if ($ri== 0 && $offset>1) {// если сегмент==0 & не последний уровень(там Units)
                    $offset--;
                    continue;
                }
                // нормализация
                $ri = str_pad($ri, 3, '0', STR_PAD_LEFT);
                // получаем циферки для анализа
                $r1 = (int)substr($ri, 0,1); //первая цифра
                $r2 = (int)substr($ri,1,1); //вторая
                $r3 = (int)substr($ri,2,1); //третья
                $r22= (int)$r2.$r3; //вторая и третья
                // разгребаем порядки
                if ($ri>99) $o[] = $str[100][$r1]; // Сотни
                if ($r22>20) {// >20
                    $o[] = $str[10][$r2];
                    $o[] = $sex[ $sexi ][$r3];
                }
                else { // <=20
                    if ($r22>9) $o[] = $str[11][$r22-9]; // 10-20
                    elseif($r22> 0) $o[] = $sex[ $sexi ][$r3]; // 1-9
                }
                // Рубли
                $o[] = self::morph($ri, $forms[$offset][ 0],$forms[$offset][1],$forms[$offset][2]);
                $offset--;
            }
        }
        // Копейки
        if (!$stripkop) {
            $o[] = $kop;
            $o[] = self::morph($kop,$forms[ 0][ 0],$forms[ 0][1],$forms[ 0][2]);
        }
        return preg_replace("/\s{2,}/",' ',implode(' ',$o));
    }

    /**
     * Склоняем словоформу
     * @param int $n
     * @param string $f1
     * @param string $f2
     * @param string $f5
     * @return string
     */
    private static function morph($n, $f1, $f2, $f5) {
        $n = abs($n) % 100;
        $n1= $n % 10;
        if ($n>10 && $n<20) return $f5;
        if ($n1>1 && $n1<5) return $f2;
        if ($n1==1) return $f1;
        return $f5;
    }

    public static function mb_ucfirst($string, $encoding = 'utf8')
    {
        $strlen = mb_strlen($string, $encoding);
        $firstChar = mb_substr($string, 0, 1, $encoding);
        $then = mb_substr($string, 1, $strlen - 1, $encoding);
        return mb_strtoupper($firstChar, $encoding) . $then;
    }

    public function filterPurify($value)
    {
        $purifier = new \CHtmlPurifier();
        $purifier->options = array(
            'HTML.AllowedElements'   => array(),
            'HTML.AllowedAttributes' => array(),
        );
        return trim($purifier->purify($value));
    }

    public function getUniqString($salt, $length = 12)
    {
        $salt = substr($salt, max(0, strlen($salt) - 3));
        $salt = strlen($salt) == 3 ? $salt : '0'.$salt;
        $chars  = 'abcdefghijkmnpqrstuvwxyz1234567890';
        $result = '';
        while (strlen($result) < $length)
        {
            if ((strlen($result)) % 4 != 0)
            {
                $invert  = mt_rand(1,5);
                $result .= ($invert == 1) ? strtoupper($chars[mt_rand(0, strlen($chars)-1)]) : $chars[mt_rand(0, strlen($chars)-1)];
            }
            else
            {
                $key = intval((strlen($result)) / 4);
                $result .= $salt[$key];
            }
        }
        return $result;
    }

    /**
     * @param string $str
     * @return string
     */
    public static function getOnlyNumbers($str) {
        return preg_replace('/[^0-9]/i', '', $str);
    }

    /**
     * @param $str
     * @return mixed|string
     */
    public static function clear($str)
    {
        $str = trim($str);
        $purifier = new \CHtmlPurifier();
        $purifier->options = [
            'HTML.AllowedElements'   => [],
            'HTML.AllowedAttributes' => [],
        ];
        $str = $purifier->purify($str);
        $str = str_replace(["\r\n","\n"], "", $str);
        return $str;
    }
}
