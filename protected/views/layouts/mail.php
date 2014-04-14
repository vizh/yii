<!-- Inliner Build Version 4380b7741bb759d6cb997545f3add21ad48f010b -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;">
<head>
  <!-- If you delete this meta tag, Earth will fall into the sun. -->
  <meta name="viewport" content="width=device-width" />
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta charset="utf-8" />
  <title><?=\Yii::t('app', 'Письмо');?></title>
</head>
<body bgcolor="#FFFFFF" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; margin: 0; padding: 0;">
<?=$content?><table class="footer-wrap" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; width: 100%; clear: both !important; margin: 5px 0 0; padding: 0;"><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;"><td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; color: #909090; line-height: 1.5; text-align: center; font-size: 9px; margin: 0; padding: 0;" align="center"></td>
    <td class="container" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; color: #909090; line-height: 1.5; text-align: center; font-size: 9px; display: block !important; max-width: 720px !important; clear: both !important; margin: 0 auto; padding: 0;" align="center">
      <div class="content" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; max-width: 720px; display: block; margin: 0 auto; padding: 0;">
        <table style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; width: 100%; margin: 0; padding: 0;"><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;"><td align="center" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; color: #909090; line-height: 1.5; text-align: center; font-size: 9px; margin: 0; padding: 0;">
              Вы получили это письмо, так как являетесь <a href="<?=$this->user->getUrl();?>" target="_blank" style="color: #909090; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;">пользователем</a> RUNET—ID и подписаны на новостную рассылку. Вы можете <a href="<?=$this->createAbsoluteUrl('/user/unsubscribe/index', ['email' => $this->user->Email, 'hash' => $this->user->getHash()]);?>" target="_blank" style="color: #909090; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;">отписаться</a> от новостных рассылок.
            </td>
          </tr></table></div><!-- /content -->

    </td>
    <td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; color: #909090; line-height: 1.5; text-align: center; font-size: 9px; margin: 0; padding: 0;" align="center"></td>
  </tr></table><!-- /FOOTER --></body>
</html>
