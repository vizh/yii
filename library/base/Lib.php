<?php
class Lib
{  
  private static $logger = null;
  /**
  * Записывает трейс сообщение.
  * Этот метод пишет лог только тогда, когда приложение находится в дебаг-режиме
  * @param string Сообщение для логгирования
  * @param string Категория сообщения
  * @see log
  */
  public static function trace($msg, $category='application')
  {
    if (Registry::GetVariable('debug'))
    {
      self::log($msg, CLogger::LEVEL_TRACE, $category);
    }      
  }

  /**
  * Логгирует сообщение.
  * Сообщения логгированные этим методом могут быть получены с помощью {@link CLogger::getLogs}
  * и могут быть записаны в различные ресурсы, такие как файл, е-меил, ДБ, используя
  * {@link CLogRouter}.
  * @param string Сообщение для логгирования
  * @param string Уровень опасности сообщения (e.g. 'trace', 'warning', 'error').
  * @param string Категория сообщения (e.g. 'library.db').
  */
  public static function log($msg, $level=CLogger::LEVEL_INFO, $category='application')
  {
    $logger = self::GetLogger();    
    $logger->log($msg, $level, $category);
  }
    
  /**
  * @return CLogger message logger
  */
  public static function GetLogger()
  {
    if(self::$logger!==null)
    {
      return self::$logger;
    }      
    else
    {
      return self::$logger = new CLogger();
    }      
  }
  
  /**
  * Выполняет базовую очистку, пустые символы, итп
  *
  * @access  public
  * @param array Входящие данные
  * @return array Очищенные данные
  */
  static public function CleanGlobals( &$data, $iteration = 0 )
  {
    // Crafty hacker could send something like &foo[][][][][][]....to kill Apache process
    // We should never have an input array deeper than 10..

    if ( $iteration >= 10 )
    {
      return;
    }
        
    foreach( $data as $key => $value )
    {
      if ( is_array( $value ) )
      {
        self::cleanGlobals( $data[ $key ], ++$iteration );
      }
      else
      {
        # Null byte characters
        $value = str_replace( chr('0') , '', $value );
        $value = str_replace( "\0"    , '', $value );
        $value = str_replace( "\x00"  , '', $value );
        $value = str_replace( '%00'   , '', $value );

        # File traversal
        $value = str_replace( "../", "&#46;&#46;/", $value );

        $data[ $key ] = $value;
      }
    }
  }
  
   /**
   * Удаляет слеши если magic_quotes включена
   *
   * @access  public
   * @param  string    Input String
   * @return  string    Parsed string
   */
  static public function Stripslashes($t)
  {
    if ( Registry::GetVariable('MagicQuotes') )
    {
        $t = stripslashes($t);
        $t = preg_replace( "/\\\(?!&amp;#|\?#)/", "&#092;", $t );
      }

      return $t;
  }
  
  /**
   * Очищает ключи и значения
   * вставляет в исходящий массив
   *
   * @param  mixed $data Input data
   * @param  array $input Storage array for cleaned data
   * @param  integer $iteration Current iteration
   * @return  array Cleaned data
   */
  public static function ParseIncoming($data, $input=array(), $iteration = 0)
  {
    // Crafty hacker could send something like &foo[][][][][][]....to kill Apache process
    // We should never have an input array deeper than 10..

    if ( $iteration >= 10 )
    {
      return $input;
    }
    
    foreach( $data as $k => $v )
    {
      if ( is_array( $v ) )
      {
        $input[ $k ] = self::ParseIncoming( $data[ $k ], array(), ++$iteration );
      }
      else
      {
        //TODO: Очистка входящих значений
        //$k = IPSText::parseCleanKey( $k );
        //$v = IPSText::parseCleanValue( $v );

        $input[ $k ] = $v;
      }
    }
    return $input;
  }
  
  /**
  * Возвращает уникальный идентификатор
  * @return string
  */
  public static function GetUniqueId() 
  {
    return md5(microtime(false));
  }
  
  /**
  * Преобразует строковое представление даты в Юникс тайм стамп
  * 
  * @param string $date
  * @return int
  */
  public static function ConvertDateToTimestamp($date)
  {
    $dateParts = date_parse($date);
    $date = mktime(0,0,0, $dateParts['month'], $dateParts['day'], $dateParts['year']);
    return $date;
  }
  
  /**
  * Подготавливает строку к помещению в sql-запрос в оператор LIKE
  * 
  * @param string $sqlString
  * @return string
  */
  public static function PrepareSqlStringForLike($sqlString)
  {    
    $sqlString = str_replace('\\', '\\\\', $sqlString);    
    $sqlString = addcslashes($sqlString, '_%');
    return $sqlString;
  }
  
  /**
  * Преобразует массив данных, в 2 массива: массив ключей и массив связок ключ=>значение
  * Используется для автоматической подстановки параметров в ПДО
  * 
  * @param array $data
  * @param array $nameBase
  */
  public static function TransformDataArray($data, $nameBase = ':Name')
  {
    $size = sizeof($data);
    $result = array();
    $result[0] = array();
    $result[1] = array();
    $i = 0;
    foreach ($data as $value)
    {
      $tmpName = $nameBase . $i;
      $result[0][] = $tmpName;
      $result[1][$tmpName] = $value;
      $i++;
    }
    return $result;
  }
  
   /**
    * Возвращает значение ассоциированое с ключем $Needle в ассоциативном массиве $Haystack
    * or $Default если не найдено. Это регистронезависимый поиск.
    *
    * @param string Ключ для поиска в $Haystack
    * @param array Ассоциативный массив в котором осуществляется поиск ключа $Needle
    * @param string Значение по умолчанию возвращаемое в случае отсутствия ключа поиска
    */
    public static function ArrayValueI($Needle, $Haystack, $Default = FALSE) {
      $Return = $Default;
      if (is_array($Haystack)) {
         foreach ($Haystack as $Key => $Value) {
            if (strtolower($Needle) == strtolower($Key)) {
               $Return = $Value;
               break;
            }
         }
      }
      return $Return;
    }

    public static function Redirect($url)
    {
     header("Location: " . $url);
     die;
    }

    public static function GetReferer($defaultValue = '') 
    {
     return array_key_exists('HTTP_REFERER', $_SERVER) ? $_SERVER['HTTP_REFERER'] : $defaultValue;
    }

    public static function IsReferer($defaultValue) 
    {
     return (stristr(self::GetReferer(), $defaultValue) !== false);
    }

    public static function IsSelfReferer()
    {
     return self::IsReferer($_SERVER['SERVER_NAME']);
    }


    public static function DetectUTF8($str)
    {
     return mb_check_encoding($str, 'UTF-8');
    }
   
    /**
    * 
    * @param int $day
    * @param int $month
    * @param int $year
    * @return int 0 - понедельник, 6 - воскресение
    */
    public static function GetWeekDay($timestamp)
    {
     $dateList = getdate($timestamp);
     $wday = ($dateList['wday'] + 6) % 7;
     return $wday;
    }
   
   /**
   * Конвертация даты из формата DATE (####-##-##) в массив
   *
   * @param string $date дата
   * @return array
   */
    public static function ConvertDateToArray($date) 
    {
      $date = preg_split('/-/', $date, -1, PREG_SPLIT_NO_EMPTY);

      if ($date[0] != '0000' && $date[1] != '00') 
      {
        return array('year' => intval($date[0]), 'month' => intval($date[1]), 'day' => intval($date[2]));
      }
      else
      {
        return false;
      }
    }

  public static function SendErrorEmail($subject, $body)
  {
    AutoLoader::Import('library.mail.*');

    $mail = new PHPMailer(false);
    $mail->AddAddress('nikitin@internetmediaholding.com');
    $mail->SetFrom('error@rocid.ru', 'rocID', false);
    $mail->CharSet = 'utf-8';
    $mail->Subject = '=?UTF-8?B?'. base64_encode($subject) .'?=';
    $mail->AltBody = 'Для просмотра этого сообщения необходимо использовать клиент, поддерживающий HTML';
    $mail->MsgHTML($body);
    $mail->Send();
  }
}