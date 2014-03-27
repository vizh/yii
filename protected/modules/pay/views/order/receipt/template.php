<?php
use application\components\utility\Texts;

/**
 * @var $order \pay\models\Order
 * @var $billData array
 * @var $total int
 * @var $nds int
 * @var $withSign bool
 * @var $template \pay\models\OrderJuridicalTemplate
 */
?>

<style type="text/css">
  p	{
    font-family: Arial, Helvetica, sans-serif;
    font-size:  9pt;
  }
  td	{
    font-family: Arial, Helvetica, sans-serif;
    font-size:  9pt;
  }
  #small	{
    font-family: Arial, Helvetica, sans-serif;
    font-size:  8pt;
  }
  #title	{
    font-family: Tahoma, Helvetica;
    font-size: 11pt;
  }
  a:hover   {
    color: #FF0000;
  }
  table.receipt  tbody > tr > td{
    border: 1px solid #000;
    padding: 3px;
  }
  table.receipt table{
    border-bottom: 1px solid #000;
  }

  /*table.receipt-data > tbody > tr > td{
    border: 1px solid #000;
    padding: 5px;
  }*/
</style>


<table class="receipt" cellspacing="0" border="1" cellpadding="3" width="640" bordercolorlight="#000000" bordercolordark="#FFFFFF">
  <tbody>
  <tr>
    <td align="left" width="240" valign="middle">
      &nbsp;&nbsp;<strong>ИЗВЕЩЕНИЕ</strong>
      <br />
      <br />
      <br />
      <br />
      <br />
      <br />
      <br />
      <br />
      <br />
      <br />
      <br />
      <br />
      <br />
      <br />
      <br />
      &nbsp;&nbsp;Кассир<br />
    </td>
    <td align="right" width="400" valign="middle">
      <table cellspacing="0" border="1" cellpadding="3" width="410" bordercolorlight="#000000" bordercolordark="#FFFFFF">
        </tr>
        <td colspan="3">Получатель платежа: 		<?=$template->Recipient;?>, ИНН:&nbsp;<?=$template->INN;?><br>
          Р/c: <?=$template->AccountNumber;?>,<br>	<?=$template->Bank;?>,<br />
          Корр.сч.: <?=$template->BankAccountNumber;?>,<br />
          БИК: <?=$template->BIK;?></td>
        <tr>
          <td colspan="3"><br /><br />
            <hr size="1" color="#000000">
            <div align="center" style="font-family: sans-serif; font-size: 8pt"><small><small>фамилия, и. о., адрес</small></small></div>
          </td>
        </tr>
        <tr>
          <td align="center">Вид платежа</td>
          <td align="center">Дата</td>
          <td align="center">Сумма</td>
        </tr>
        <tr>
          <td align="left">&nbsp;<br>Оплата счета № <?=$order->Number;?> от <?=date('d.m.Y', strtotime($order->CreationTime));?><br>&nbsp;</td>
          <td valign="bottom" width="75"><img src="/images/b.gif" width="75" height="1" border="0"></td>
          <td valign="middle" align="center" width="75"><?=number_format($total, 2, ',', ' ');?> руб.</td>
        </tr>
        <tr>
          <td align="left" rowspan="2" colspan="3" valign="center"><br />Плательщик:</td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td align="left" width="240" valign="middle">
      &nbsp;&nbsp;<strong>КВИТАНЦИЯ</strong>
      <br />
      <br />
      <br />
      <br />
      <br />
      <br />
      <br />
      <br />
      <br />
      <br />
      <br />
      <br />
      <br />
      <br />
      <br />
      &nbsp;&nbsp;Кассир<br />
    </td>
    <td align="right" width="400" valign="middle">
      <table cellspacing="0" border="1" cellpadding="3" width="410" bordercolorlight="#000000" bordercolordark="#FFFFFF">
        <tr>
          <td colspan="3">Получатель платежа: 		<?=$template->Recipient;?>, ИНН:&nbsp;<?=$template->INN;?><br>
            Р/c: <?=$template->AccountNumber;?>,<br>	<?=$template->Bank;?>,<br />
            Корр.сч.: <?=$template->BankAccountNumber;?>,<br />
            БИК: <?=$template->BIK;?></td>
        </tr>
        <tr>
          <td colspan="3"><br /><br />
            <hr size="1" color="#000000">
            <div align="center" style="font-family: sans-serif; font-size: 8pt"><small>фамилия, и. о., адрес</small></div>
          </td>
        </tr>
        <tr>
          <td align="center">Вид платежа</td>
          <td align="center">Дата</td>
          <td align="center">Сумма</td>
        </tr>
        <tr>
          <td align="left">&nbsp;<br>Оплата счета № <?=$order->Number;?> от <?=date('d.m.Y', strtotime($order->CreationTime));?><br>&nbsp;</td>
          <td valign="bottom" width="75"><img src="/images/b.gif"  height="1" border="0"></td>
          <td valign="middle" align="center" width="75"><?=number_format($total, 2, ',', ' ');?> руб.</td>
        </tr>
        <tr>
          <td align="left" rowspan="2" colspan="3" valign="center"><br />Плательщик:</td>
        </tr>
      </table>
    </td>
  </tr>
  </tbody>
</table>



