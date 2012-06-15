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
            <h2>Получена новая вакансия</h2>
            <br>
            <br>
            Название: <?=$this->Title;?><br>
            Компания: <?=$this->Company;?><br>
            Контактный email: <?=$this->Email;?><br>
            Зарплата: <?if ($this->SalaryMin != 0):?>от <?=$this->SalaryMin;?><?endif?> <?if ($this->SalaryMax != 0):?>до <?=$this->SalaryMax;?><?endif?> <?if ($this->SalaryMin == 0 && $this->SalaryMax == 0):?>не указана<?endif?>
            <br>
            <br>
            Обязанности: <?=$this->Responsibility;?><br>
            Требования: <?=$this->Requirements;?><br>
            <br>
            <br>
            Вакансию отправил:  <?=$this->LastName;?> <?=$this->FirstName;?> (rocID: <?=$this->RocId;?>)
            <br>
          </td>
        </tr>
      </table>
    </div>
  </div>
</body>
</html>