<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>rocID Регистрация</title>
  <style type="text/css">

    .tbl .message{

    }
  </style>
</head>
<body>
  <div style="text-align:center;margin:0;font-family:tahoma, arial, verdana;padding-top:20px;">
    <div style="width:602px;padding:50px;margin:0 auto;">
      <table style="width: 100%;">
        <tr>
          <td style="text-align:left;">
            <a href="http://<?=$this->Host;?>/">
              <img src="http://<?=$this->Host;?>/images/logo.png" alt="rocID:// - Информационный портал профессионалов Рунета">
            </a>
          </td>
        </tr>
        <tr>
          <td style="font-size:12px;padding-top:20px;color:#444;text-align:left;">
            Спасибо за регистрацию в сети rocID.
            <br>
            <br>
            Информация ниже необходима для авторизации в сети.
            <br>
            <br>
            Email: <?=$this->Email;?><br>
            rocID: <?=$this->RocID;?><br>
            Пароль: <?=$this->Password;?><br>
            <br>
            <br>
            [Это автоматически сгенерированное письмо, не отвечайте на него.]
            <br>
            <br>
            Спасибо!,<br>
            <a href="http://<?=$this->Host;?>/"><?=$this->Host;?></a>
          </td>
        </tr>
      </table>
    </div>
  </div>
</body>
</html>