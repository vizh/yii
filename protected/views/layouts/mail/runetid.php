<?$this->beginContent('/layouts/mail');?>
  <table class="body-wrap" border="0" cellpadding="0" cellspacing="0" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; width: 100%; margin: 0; padding: 0 10px; border-collapse: separate;"><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;"><td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;"></td>
      <td class="container" bgcolor="#FFFFFF" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; display: block !important; max-width: 720px !important; clear: both !important; margin: 0 auto; padding: 0;">
        <table style="border-collapse: separate; width: 100%; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td>&nbsp;</td>
            <td style="font-size: 25px; font-weight: bold; line-height: 25px; text-align: center; width: 100px; padding: 5px; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0;" rowspan="2">RUNET</td>
            <td>&nbsp;</td>
            <td style="font-size: 25px; font-weight: bold; line-height: 25px; width: 30px; text-align: center; padding: 5px; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0;" rowspan="2">ID</td>
            <td>&nbsp;</td>
            <td rowspan="2" style="font-size: 25px; font-weight: bold; line-height: 25px; width: 1px; text-align: center; padding: 5px; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0;"><?=$this->user->RunetId;?></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td style="border-width: 3px 0 0 3px; border-color: #000; border-style: solid; width: 30px; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;">&nbsp;</td>
            <td style="border-top: 3px solid #000; width: 20px; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;">&nbsp;</td>
            <td style="border-top: 3px solid #000; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;">&nbsp;</td>
            <td style="border-top: 3px solid #000; border-right: 3px solid #000; width: 35px; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;">&nbsp;</td>
          </tr>
        </table><div class="column-wrap" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; max-width: 720px !important; margin: 0 auto; padding: 0 20px; border-color: #000; border-style: solid; border-width: 0px 3px 3px;">
          <?=$content;?>
          <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; width: 100%; margin: 0; padding: 10px 0; color: #909090; text-align: center;">Ссылки в письме являются персональными, не пересылайте письмо третьим лицам.</p>
        </div>
      </td>
      <td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;"></td>
    </tr></table><!-- /BODY --><!-- FOOTER -->
<?$this->endContent();?>