<?
//
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->RestartBuffer();
global $participationPrice;

if ($_SERVER['REMOTE_ADDR'] != '207.97.254.211') {
	echo 'REMOTE_ADDR mismatch';
	header('Status: 500');
	exit();
}

CModule::IncludeModule('iblock');
CModule::IncludeModule('rocid');
$el = new CIBlockElement();
$el->Add(array(
	'IBLOCK_ID'      => 2,
	'MODIFIED_BY'    => 1,
	'NAME'        => '['.$_REQUEST['cs1'].'] '.$_REQUEST['name'],
	'ACTIVE_FROM'    => date('d.m.Y H:i:s'),
	'PREVIEW_TEXT'    => var_export($_REQUEST, true),
	'PREVIEW_TEXT_TYPE'  => 'text',
	'DETAIL_TEXT_TYPE'  => 'text',
	'PROPERTY_VALUES'  => array(
		'ROCID'      => $_REQUEST['cs1'],
		'TOTAL'      => $_REQUEST['total'],
		'TRANSACTION'  => $_REQUEST['transaction_id'],
		'SYSTEM'  => $_REQUEST['cs2'],
		'DETAILS'  => $_REQUEST['cs3']
	),
));

if ($_REQUEST['transaction_type'] == 'Purchase') {
	$rocid = $_REQUEST['cs1'];
	$ROCIDUSER->AuthorizeByRocID($rocid);
	UpdateParticipationPrice();
	if ($ROCIDUSER->GetRole() != 1) {
		$GLOBALS['participationPrice'] = 0;
	}
	if (((int)$GLOBALS['participationPrice']) != ((int)$_REQUEST['total'])) {
		$arEventFields = array(
			'EXPECTED'      => $GLOBALS['participationPrice'],
			'RECEIVED'      => $_REQUEST['total'],
			'CS1'        => $_REQUEST['cs1'],
			'CS2'        => $_REQUEST['cs2'],
			'CS3'        => $_REQUEST['cs3'],
			'TRANSACTION_ID'  => $_REQUEST['transaction_id'],
		);
		CEvent::Send(
			'CHRONO_PRICE_MISMATCH',
			SITE_ID,
			$arEventFields
		);
	}

	// ����������� ������������ �� �������
	$email = $_SESSION['ROCID_DATA']['EMAIL'];
	if ($email != '') {
		$arEventFields = array(
			'RECEIVED'      => $_REQUEST['total'],
			'TRANSACTION_ID'  => $_REQUEST['transaction_id'],
			'EMAIL_TO'  => $email,
		);

    $mailTemplate = ($_REQUEST['cs3'] == 'videoPay') ? 'ROCID_EVENT_REG_VIDEO' : 'ROCID_EVENT_REG_PRO';
    CEvent::Send(
      $mailTemplate,
      SITE_ID,
      $arEventFields
    );
		
	}

  /** @todo: cabinet link */
  $status = ($_REQUEST['cs3'] == 'videoPay') ? 26 : 11;
  $ROCIDUSER->RegisterToEvent(1, $status, true);
}
