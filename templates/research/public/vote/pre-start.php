<div class="content">
  <div class="vacancies add-vacancy">
    <h1>«ЭКОНОМИКА РУНЕТА-2012». ЭЛЕКТРОННАЯ АНКЕТА</h1>

    <div class="vote">
      <h2>Блок А. Информация об эксперте.</h2>

      <p>
        Просим проверить и, в случае необходимости, изменить или дополнить Ваши контактные данные.
      </p>

      <form action="" method="post" id="vote_form">
        <input type="hidden" value="1" name="start">

        <div class="question">

          <div class="question-title">
            <h3>УКАЖИТЕ ВАШИ ФАМИЛИЮ, ИМЯ, ОТЧЕСТВО (ПОЛНОСТЬЮ)<span>*</span></h3>
            <span class="question-info">Введите ответ</span>

            <?if (isset($this->Errors['Name'])):?>
            <br><span class="question-error"><?=$this->Errors['Name'];?></span>
            <?endif;?>
          </div>

          <ul>
            <li>
              <input type="text" autocomplete="off" value="<?=$this->Data['Name'];?>" name="Data[Name]">
            </li>
          </ul>

        </div>

        <div class="question">

          <div class="question-title">
            <h3>НАЗОВИТЕ ДАТУ ВАШЕГО РОЖДЕНИЯ (ДД.ММ.ГГГГ)<span>*</span></h3>
            <span class="question-info">Введите ответ</span>
            <?if (isset($this->Errors['Birthday'])):?>
            <br><span class="question-error"><?=$this->Errors['Birthday'];?></span>
            <?endif;?>
          </div>
          <ul>
            <li>
              <input type="text" autocomplete="off" value="<?=$this->Data['Birthday'];?>" name="Data[Birthday]">
            </li>
          </ul>

        </div>

        <div class="question">

          <div class="question-title">
            <h3>УКАЖИТЕ ВАШЕ ОСНОВНОЕ МЕСТО РАБОТЫ (ПОЛНОЕ НАЗВАНИЕ КОМПАНИИ/ОРГАНИЗАЦИИ)<span>*</span></h3>
            <span class="question-info">Введите ответ</span>
            <?if (isset($this->Errors['Company'])):?>
            <br><span class="question-error"><?=$this->Errors['Company'];?></span>
            <?endif;?>
          </div>

          <ul>
            <li>
              <input type="text" autocomplete="off" value="<?=$this->Data['Company'];?>" name="Data[Company]">
            </li>
          </ul>

        </div>

        <div class="question">

          <div class="question-title">
            <h3>НАЗОВИТЕ ВАШУ ДОЛЖНОСТЬ ПО ОСНОВНОМУ МЕСТУ РАБОТЫ<span>*</span></h3>
            <span class="question-info">Введите ответ</span>
            <?if (isset($this->Errors['Position'])):?>
            <br><span class="question-error"><?=$this->Errors['Position'];?></span>
            <?endif;?>
          </div>

          <ul>
            <li>
              <input type="text" autocomplete="off" value="<?=$this->Data['Position'];?>" name="Data[Position]">
            </li>
          </ul>
        </div>

      </form>
    </div>

    <div class="response" style="width: 200px; float: right;">
      <a href="" onclick="$('#vote_form')[0].submit(); return false;">Далее</a>
    </div>

  </div>

  <div class="sidebar sidebarcomp">
    <?=$this->Banner;?>
  </div>
</div>