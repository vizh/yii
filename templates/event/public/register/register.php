<div class="content">
  <div class="vacancies add-vacancy">
    <h2>Регистрация на мероприятии</h2>

    <p>Подтвердите свое согласие на регистрацию на мероприятие <strong><?=$this->Name;?></strong></p>

    <div class="response" style="float: left; padding-right: 35px;">
      <form id="register_on_event" action="" method="post">
        <a href="" onclick="$('#register_on_event')[0].submit(); return false;">Зарегистрироваться</a>
      </form>
    </div>

    <div class="response" style="float: left;">
      <a href="<?=RouteRegistry::GetUrl('event', '', 'show', array('idName' => $this->IdName));?>">Отмена</a>
    </div>

  </div>

</div>