<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->RestartBuffer();
global $participationPrice;

//Проверка секьюрити кода
$privateSecurityKey = '8cce489d-57d6-41ea-bf3f-c9b6c35db540';
$baseQuery = "DateTime=".$_REQUEST['DateTime'].
						 "&TransactionID=".$_REQUEST['TransactionID'].
						 "&OrderId=".$_REQUEST['OrderId'].
						 "&Amount=".$_REQUEST['Amount'].
						 "&Currency=".$_REQUEST['Currency'].
						 "&PrivateSecurityKey=".$privateSecurityKey;
$hash = md5($baseQuery);

if ($hash != $_REQUEST['SecurityKey']) {
	mail(
			'eroshenko@rocit.ru',
			'[2011.russianinternetweek.ru] Wrong Security Key',
			"Received: " .  var_export($_REQUEST, true) . " \n".
			"Transaction ID: $_REQUEST[TransactionID]\n",
			'Cc: borzov@rocit.ru, nikitin@rocit.ru'
		);
	header('Status: 500');
	exit();
}

CModule::IncludeModule('iblock');
CModule::IncludeModule('rocid');
$el = new CIBlockElement();
$logId = $el->Add(array(
	'IBLOCK_ID'      => 2,
	'MODIFIED_BY'    => 1,
	'NAME'        => '['.$_REQUEST['rocid'].'] '.$_REQUEST['CardHolder'],
	'ACTIVE_FROM'    => date('d.m.Y H:i:s'),
	'PREVIEW_TEXT'    => var_export($_REQUEST, true),
	'PREVIEW_TEXT_TYPE'  => 'text',
	'DETAIL_TEXT_TYPE'  => 'text',
	'PROPERTY_VALUES'  => array(
		'ROCID'      => $_REQUEST['rocid'],
		'TOTAL'      => $_REQUEST['Amount'],
		'TRANSACTION'  => $_REQUEST['TransactionID'],
		'SYSTEM' => $_REQUEST['system'],
		'DETAILS' => $_REQUEST['OrderId']
	),
));


$rocid = $_REQUEST['rocid'];
$total = $_REQUEST['Amount'];
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
		'CS3'        => $_REQUEST['extra'],
		'TRANSACTION_ID'  => $_REQUEST['TransactionID'],
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
		'TRANSACTION_ID'  => $_REQUEST['TransactionID'],
		'EMAIL_TO'  => $email,
	);

  $mailTemplate = ($_REQUEST['extra'] == 'videoPay') ? 'ROCID_EVENT_REG_VIDEO' : 'ROCID_EVENT_REG_PRO';
	CEvent::Send(
		$mailTemplate,
		SITE_ID,
		$arEventFields
	);

}

/** @todo: cabinet link */
$status = ($_REQUEST['extra'] == 'videoPay') ? 26 : 11;
$ROCIDUSER->RegisterToEvent(1, $status, true);