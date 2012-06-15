<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>rocID отзыв на вакансию</title>
</head>
<body>
  <div style="text-align:center;margin:0;font-family:tahoma, arial, verdana;padding-top:20px;">
    <div style="width:602px;padding:50px;margin:0 auto;">
      <table style="width: 100%;">
        <tr>
          <td style="font-size:12px;padding-top:20px;color:#444;text-align:left;">
            Отзыв на вакансию <a target="_blank" href="<?=RouteRegistry::GetUrl('job', '', 'show', array('id' => $this->VacancyId));?>"><?=$this->Title;?></a>
            <br>
            <br>
            Информация о кандидате.
            <br>
            <br>
            <strong>Имя:</strong> <?=$this->Name;?><br>
            <strong>Email:</strong> <?=$this->Email;?><br>
            <br>
            <strong>Описание:</strong><br>
            <?=$this->Description;?>
            <br>
            <br>
          </td>
        </tr>
      </table>
    </div>
  </div>
</body>
</html>