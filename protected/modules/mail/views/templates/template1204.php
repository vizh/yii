<?php	
	$link = "http://riw.moscow/auth/fast?runet_id=" . $user->RunetId . "&key=" . substr(md5($user->RunetId.'awjdn2iuh4i3hudaiubdiwuabd'), 0, 16) . "&redirect=/my";
	$poll = "http://riw.moscow/auth/fast?runet_id=" . $user->RunetId . "&key=" . substr(md5($user->RunetId.'awjdn2iuh4i3hudaiubdiwuabd'), 0, 16) . "&redirect=/poll";
?>

<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>RIW 2016 завершен: ИТОГОВЫЙ ОПРОС</title>
    <!--[if (gte mso 9)|(IE)]>
      <style>
        td {
        	                font-family: Helvetica, Arial, sans-serif;
        	            }
      </style>
    <![endif]-->
    <style type="text/css">
      @media only screen and (min-device-width: 601px) {
                      .content {
      	                width: 600px !important
      	            }
                  }
                  @media screen and (max-width: 600px) {
                      .content {
      	                width: 100%!important
      	            }
                      .wrapper {
                          padding: 20px!important
                      }
                  }
    </style>
  </head>
  <body yahoo bgcolor="#F1F1F1" style="margin:0;padding:0;min-width:100% !important;">
    <table width="100%" bgcolor="#F1F1F1" border="0" cellpadding="0" cellspacing="0" style="padding-bottom: 20px">
      <tr>
        <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
          <!--[if (gte mso 9)|(IE)]>
            <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td>
          <![endif]-->
          <table class="content" align="center" cellpadding="0" cellspacing="0" border="0" style="width:100%;max-width:600px;position:relative;">
            <tr>
              <td class="wrapper" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;padding:20px 33px;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="center" class="h2" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;color:#111111;font-family:&quot;Helvetica Neue&quot;, Helvetica, Arial, &quot;Lucida Grande&quot;, sans-serif;font-weight:200;line-height:1.2em;margin:10px 0;font-size:28px;"><?=$user->getShortName()?>, здравствуйте!</td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
          <!--[if (gte mso 9)|(IE)]>
          </td>
        </tr>
      </table>
          <![endif]-->
          <!--[if (gte mso 9)|(IE)]>
            <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td>
          <![endif]-->
          <table class="content" align="center" cellpadding="0" cellspacing="0" border="0" style="width:100%;max-width:600px;position:relative;">
            <tr>
              <td class="wrapper section-white" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;padding:20px 33px;background-color:#ffffff;">
                <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0">
                  <!--[if (gte mso 9)|(IE)]>
                    <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td height="30px">
                        </td>
                      </tr>
                    </table>
                  <![endif]-->
                  <tr class="table-list">
                    <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;text-align: center; vertical-align: top; font-size: 0;">
                      <div class="ou" style="width: 267px; display: inline-block; vertical-align: top; margin-left: 0;margin-right: 0; mso-width-alt: 260px !important">
                        <table width="267" align="left" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff">
                          <tr>
                            <td width="51" valign="middle" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px">
                              <img class="person-photo" src="https://runet-id.com/<?=$user->getPhoto()->get50px();?>" width="51" height="51">
                            </td>
                            <td class="person-name" width="203" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;text-align:center"><a href="<?=$user->getProfileUrl();?>"><?=$user->getName();?></a></td>
                            <td width="16" valign="middle" align="left" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px">
                              <a href="<?=$link?>">
                                <img class="person-photo" src="http://vizh.share.s3.amazonaws.com/ruvents/riw2016/img-lk.jpg" width="16" height="16" style="padding-top: 4px">
                              </a>
                            </td>
                          </tr>
                        </table>
                      </div>
                      <div class="ou" style="width: 242px; display: inline-block; vertical-align: top; margin-left: 25px;margin-right: 0; mso-width-alt: 235px !important">
                        <table width="242" align="center" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff">
                          <tr>
                            <td width="219" height="51" valign="middle" align="center" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                              <a href="<?=$link?>" target="_blank" class=" btn-registration" style="display:inline-block;">
                                <img src="http://vizh.share.s3.amazonaws.com/ruvents/riw2016/Рассылка/img-btn-to-lk-pink.jpg" height="37" style="padding: 7px 0"/>
		                                                                </a>
                            </td>
                          </tr>
                        </table>
                      </div>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
          <!--[if (gte mso 9)|(IE)]>
          </td>
        </tr>
      </table>
          <![endif]-->
          <!--[if (gte mso 9)|(IE)]>
            <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td>
          <![endif]-->
          <table class="content section-white" align="center" cellpadding="0" cellspacing="0" border="0" style="width:100%;max-width:600px;position:relative;background-color:#ffffff;">
            <tr class="wrapper" style="padding:20px 33px;">
              <td valign="top" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                <img src="http://vizh.share.s3.amazonaws.com/ruvents/riw2016/%D0%A0%D0%B0%D1%81%D1%81%D1%8B%D0%BB%D0%BA%D0%B0/20161103(47)-riw16-top.jpg" width="600" class="head-img" style="width:100%;display:block;"/>
                                        </td>
            </tr>
          </table>
          <!--[if (gte mso 9)|(IE)]>
          </td>
        </tr>
      </table>
          <![endif]-->
          <!--[if (gte mso 9)|(IE)]>
            <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td>
          <![endif]-->
          <table class="content section-white" align="center" cellpadding="0" cellspacing="0" border="0" style="width:100%;max-width:600px;position:relative;background-color:#ffffff;">
            <tr>
              <td class="wrapper section-white" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;padding:20px 33px;background-color:#ffffff;">
                <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0">
                  <!--[if (gte mso 9)|(IE)]>
                    <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td height="1" style="padding:0; margin: 0">
                        </td>
                      </tr>
                    </table>
                  <![endif]-->
                  <tr>
                    <td align="center" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                      <p>В&nbsp;Москве закончилось самое большое осеннее событие отрасли высоких технологий&nbsp;&mdash; 3 ноября 2016 года завершил свою работу <nobr>9-я</nobr> Российская Интерактивная Неделя (RIW 2016) и&nbsp;выставка INTERNET 2016&nbsp;&mdash; <a href="http://www.riw.moscow/" target="_blank" class="black-a" style="color:#000000;">www.RIW.moscow</a></p>
                      <p><b>Вы&nbsp;стали частью проекта&nbsp;&mdash; большое спасибо Вам за&nbsp;это!</b></p>
                      <p><a href="<?=$link?>" target="_blank">Личный кабинет участника</a></p>
                    </td>
                  </tr>
                  <tr>
                    <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                      <hr class="hr-gray" style="background-color:#E2E2E2;border:none;border-top:solid 1px #E2E2E2;margin:20px 0;">
                      <h2 class="blue" align="center" style="color:#3a7da7;padding-top: 15px;">ИТОГОВЫЙ ОПРОС</h2>
                      <p align="center"><b>Ваше мнение действительно важно для нас!</b></p>
                      <p>Для того, чтобы в&nbsp;следующем году мы&nbsp;смогли сделать RIW еще лучше и&nbsp;чтобы помочь нам с&nbsp;выявлением сильных и&nbsp;слабых сторон реализации проекта в&nbsp;этом году, просим Вас пройти опрос и&nbsp;рассказать о&nbsp;своих впечатлениях.</p>
                      <p>Ответы на&nbsp;вопросы займут не&nbsp;более 5&nbsp;минут Вашего времени:</p>
                      <p align="center"><a href="<?=$poll?>" target="_blank" class="btn-pink" style="background-color:#E3227F;color:#FFFFFF;font-size:16px;padding:10px 20px;text-decoration:none;display:inline-block;margin:10px 0px;text-transform:uppercase;">Пройти итоговый опрос</a></p>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
          <!--[if (gte mso 9)|(IE)]>
          </td>
        </tr>
      </table>
          <![endif]-->
        </td>
      </tr>
    </table>
  </body>
</html>