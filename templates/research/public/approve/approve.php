<h1 class="event">Исследовательский проект «Экономика Рунета 2011-2012»</h1>

<div id="large-left" class="event-content">
	<!-- content -->
	<p>РАЭК и Национальный исследовательский университет - Высшая школа экономики проводят совместное исследовании «Экономика Рунета 2011-2012»,  основная задача которого – оценить текущее состояние и тенденции развития российских рынков интернет-бизнеса.</p>
	<p>Вы подтверждаете свое участие в работе Экспертной группы Исследования.</p>

	<p><strong>Вы авторизованы как:</strong>:</p>

  <p>
    ФИО: <?=$this->LoginUser->LastName;?> <?=$this->LoginUser->FirstName;?> <?=$this->LoginUser->FatherName;?> <br>
    <?if (isset($this->Employment)):?>
    Организация: <?=$this->Employment->Company->Name;?> <br>
    Должность: <?=$this->Employment->Position;?>
    <?endif;?>
  </p>

  <p>
    <strong>Просим проверить и - в случае необходимости - <a target="_blank" href="<?=RouteRegistry::GetUrl('user','', 'edit');?>#contact">дополнить / изменить</a> Ваши контактные данные:</strong>
  </p>

  <p>
    e-mail для связи: <a href="mailto:<?=$this->Email;?>"><?=$this->Email;?></a><br>
    моб. телефон (для оперативной связи с Вами, в т.ч. в дни проведения РИФ+КИБ): <?=!empty($this->Phone) ? $this->Phone : 'не указан';?>
  </p>

  <p><strong>Пожалуйста выберите группы рынков, экспертом по которым Вы хотели бы стать (можно стать экспертом не более чем в 2 группах): </strong></p>

  <style type="text/css">
    p.chbxs label{
      display: inline-block !important;
    }
  </style>

  <script type="text/javascript">
    $(function(){
      $('input[name="Trend[]"]').bind('click', function(){
        var checked = $('input[name="Trend[]"]:checked');
        if (checked.length > 2)
        {
          alert('Вы не можете выбрать больше двух направлений');
          return false;
        }
      });
    });
  </script>

  <form id="add_expert" action="" method="post">
    <div class="cfldset" style="margin: -15px 0 0 20px;">
      <p class="chbxs">
        <?foreach ($this->Trends as $trend):?>
        <label><input type="checkbox" name="Trend[]" value="<?=$trend->TrendId;?>" <?=in_array($trend->TrendId, $this->UserTrendId) ? 'checked="checked"' : '';?>><?=$trend->Title;?></label><br>
        <?endforeach;?>
      </p>
    </div>

    <p>И нажмите кнопку ниже: это будет означать, что Вы подтвержадете свое участие в качестве эксперта Исследования "Экономика Рунета 2011-2012": </p>

    <div class="response" style="width: 200px;">
      <a onclick="$('#add_expert')[0].submit(); return false;" href="">Подтверждаю</a>
    </div>
  </form>
<div class="clear"></div>

<!-- end large-left -->
</div>
<div class="sidebar sidebarrapple">

 <?php echo $this->Banner;?>

<!-- end sidebar -->
</div>

  <div class="clear"></div>