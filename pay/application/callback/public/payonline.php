<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
global $participationPrice;
$APPLICATION->SetTitle("Оплата");
CModule::IncludeModule('rocid');
$ROCIDUSER->ReloadUserData();
$arUser = $ROCIDUSER->GetSessionData();
if (!$ROCIDUSER->IsLoggedIn() || !$ROCIDUSER->IsParticipant()) {
	LocalRedirect('/registration/');
}
if ($ROCIDUSER->GetRole() != 1) {
	LocalRedirect('/my/');
}
$qGroupUsers = $DB->Query("SELECT `id`, `rocid` FROM `ext_group_pay` WHERE `referer` = '{$arUser['ROCID']}' AND `deleted` = '0'");
if ($qGroupUsers->SelectedRowsCount() > 0)
{
  LocalRedirect('/my/pay/entity.form.php');
}

(isset($_REQUEST['video'])) ? $participationPrice = 3000 : UpdateParticipationPrice();
$extra = (isset($_REQUEST['video'])) ? 'videoPay' : '';

$merchantId = 2452;
for($i=0; $i < 8; $i++) $idDetails .= mt_rand(0, 9);
$total = number_format($participationPrice, 2, '.', '');
$currency = 'RUB';
$securityKey = '8cce489d-57d6-41ea-bf3f-c9b6c35db540';
$returnUrl = 'http://2011.russianinternetweek.ru/my/';

$baseQuery = "MerchantId=".$merchantId.
						 "&OrderId=".$idDetails.
						 "&Amount=".$total.
						 "&Currency=".$currency;

$queryWithSecurityKey = $baseQuery."&PrivateSecurityKey=".$securityKey;

$hash = md5($queryWithSecurityKey);

$clientQuery = $baseQuery."&SecurityKey=".$hash.
							 "&ReturnUrl=".urlencode($returnUrl).
							 "&rocid=".$arUser["ROCID"].
               "&system=POS".
							 "&extra=".$extra;

$paymentFormAddress = "https://secure.payonlinesystem.com/ru/payment/select/?".$clientQuery;

header("Location: ".$paymentFormAddress);