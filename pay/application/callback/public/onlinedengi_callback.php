<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->RestartBuffer();
global $participationPrice;

//Проверка хэша
$projectId = 729;
$sourceId = 729;
$secretWord = 'riw11';
$currency = 'RUB';

$hash = md5(
  "project_id=".$projectId.
  "&source_id=".$sourceId.
  "&secret_word=".$secretWord.
  "&order_id=".$_REQUEST['orderid'].
  "&rocid=".$_REQUEST['userid'].
  "&amount=".$_REQUEST['amount'].
  "&currency=".$currency
);

if ($hash != $_REQUEST['userid_extra']) {
/*
  $file = 'pays.log';
  $fp = fopen ($file, "w");

  ob_start();
  var_dump($_REQUEST);
  $log = ob_get_clean();
  fputs($fp, "ERROR\r\n{$log}\r\n");

  fclose($fp);
  chmod($file, 0666);
*/
	mail(
			'eroshenko@internetmediaholding.com',
			'[2011.russianinternetweek.ru] Wrong Security Key',
			"Received: " . var_export($_REQUEST, true) . " \n".
			"Transaction ID: $_REQUEST[paymentid]\n",
			'Cc: borzov@rocit.ru, nikitin@rocit.ru'
		);
  echo '<?xml version="1.0" encoding="UTF-8"?><result><id>'.$_REQUEST['orderid'].'</id><code>NO</code><comment>Запрошенная сумма отличается от оплаченной</comment></result>';
  exit();
}

CModule::IncludeModule('iblock');
CModule::IncludeModule('rocid');
$el = new CIBlockElement();
$logId = $el->Add(array(
	'IBLOCK_ID'      => 2,
	'MODIFIED_BY'    => 1,
	'NAME'        => '['.$_REQUEST['userid'].']',
	'ACTIVE_FROM'    => date('d.m.Y H:i:s'),
	'PREVIEW_TEXT'    => var_export($_REQUEST, true),
	'PREVIEW_TEXT_TYPE'  => 'text',
	'DETAIL_TEXT_TYPE'  => 'text',
	'PROPERTY_VALUES'  => array(
		'ROCID'      => $_REQUEST['userid'],
		'TOTAL'      => $_REQUEST['amount'],
		'TRANSACTION'  => $_REQUEST['paymentid'],
		'SYSTEM' => 'DENGI',
		'DETAILS' => $_REQUEST['orderid']
	),
));


$rocid = $_REQUEST['userid'];
$total = $_REQUEST['amount'];
$ROCIDUSER->AuthorizeByRocID($rocid);
UpdateParticipationPrice();
if ($ROCIDUSER->GetRole() != 1) {
	$GLOBALS['participationPrice'] = 0;
}
if (((int)$GLOBALS['participationPrice']) != $total) {
	$arEventFields = array(
		'EXPECTED'      => $GLOBALS['participationPrice'],
		'RECEIVED'      => $total,
		'CS1'        => $rocid,
		'CS2'        => 0,
		'CS3'        => '',
		'TRANSACTION_ID'  => $_REQUEST['paymentid'],
	);
	CEvent::Send(
		'CHRONO_PRICE_MISMATCH',
		SITE_ID,
		$arEventFields
	);
}

// уведомление пользователя об обплате
$email = $_SESSION['ROCID_DATA']['EMAIL'];
if ($email != '') {
	$arEventFields = array(
		'RECEIVED'      => $total,
		'TRANSACTION_ID'  => $_REQUEST['paymentid'],
		'EMAIL_TO'  => $email,
	);

	CEvent::Send(
		'ROCID_EVENT_REG_PRO',
		SITE_ID,
		$arEventFields
	);

}

/** @todo: cabinet link */
$ROCIDUSER->RegisterToEvent(1, 11, true);

echo '<?xml version="1.0" encoding="UTF-8"?><result><id>'.$_REQUEST['orderid'].'</id><code>YES</code></result>';
exit();
