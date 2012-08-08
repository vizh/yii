<?php


class ExchangeRatesCBRF
{
	private  $rates;

	function __construct()
	{
    $today = date("d/m/Y");
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://www.cbr.ru/scripts/XML_daily.asp?date_req='.$today);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    $result = curl_exec($ch);
    curl_close ($ch);

    $this->rates = new SimpleXMLElement($result);
	}

	function GetRate ($code)
	{
		$code1 = (int)$code;
		if ($code1 != 0)
		{
			$result = $this->rates->xpath('/ValCurs/Valute[NumCode = "'.$code1.'"]/Value');
		}
		else
		{
			$result = $this->rates->xpath('/ValCurs/Valute[CharCode="'.$code.'"]/Value');
		}
		if (!$result)
		{
			return false;
		}
		else
		{
      return $result[0];
		}
	}
}