<?php

class TestApi extends GeneralCommand
{
  const GateDomain = 'http://zapi.beta.rocid/';
  //const GateDomain = 'http://api.rocid.ru/';

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
//    $apikey = '12345';
//    $secretkey = '67890';
    $apikey = 'mdqceRsFvK';
    $secretkey = 'oHgFAhKytMNeWk9vDKP9xPTLV';

    $timestamp = time();

    $vars = array (
      'Email' => 'malyshev@orangecode.ru',
      'Password' => '77918150Smingr',
      'FirstName' => 'Сергей',
      'LastName' => 'Малышев',
      'FatherName' => '',
      'Company' => 'Orange Code',
      'Postion' => 'директор',
      'Country' => '3159',
      'Region' => '4800',
      'City' => '4848',
      'Phone' => '+79185052385',
    );
    $url = 'user/create';
    //http://api.rocid.ru/news/list?LastRequest=1333364867&NextPageToken=bmV3OQ%3D%3D&ApiKey=bHx95u1Q4X&Hash=0cc4f73aa8650107&Timestamp=1333969667&MaxResults=10

    $hash = substr( md5 ($apikey . $timestamp . $secretkey), 0, 16);
    $url .= '/?ApiKey='. $apikey .'&Timestamp='. $timestamp .'&Hash='. $hash;
    $vars = http_build_query($vars);

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_TIMEOUT, 3);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 1);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    if (false)
    {
      curl_setopt($curl, CURLOPT_POST, 1);
      curl_setopt($curl, CURLOPT_POSTFIELDS, $vars);
    }
    else
    {
      $url .= '&'.$vars;
    }

    curl_setopt($curl, CURLOPT_URL, self::GateDomain . $url);

    echo self::GateDomain . $url;
    $result = curl_exec($curl);

    echo '<pre>';
    echo $result;

    $result = json_decode($result);

    print_r($result);


    echo '</pre>';
  }
}