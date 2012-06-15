<div class="content">
  <?php echo $this->Submenu;?>

  <div class="vacancies jobtest">
    <h2><?=$this->TestTitle;?></h2>
    <p><strong>Вопрос <?=$this->QuestionNumber;?></strong> (из <?=$this->TotalQuestions;?>).</p>
    <p>
      <?=$this->Question;?>
    </p>
    <form id="jobtest" action="" method="post">
      <ul>
        <?foreach ($this->Answers as $answer):?>
        <li><label><input type="radio" name="answer" value="<?=$answer->AnswerId;?>"><?=$answer->Answer;?></label></li>
        <?endforeach;?>
      </ul>
    </form>
    <div class="response">
      <a href="" onclick="$('#jobtest')[0].submit(); return false;">Далее</a>
    </div>
  </div>
  <div id="sidebar" class="sidebar sidebarcomp">
    <?php echo $this->PartnerBanner;?>
    <?php echo $this->JobTestPartnerBanner;?>
    <?php echo $this->Banner;?>
  </div>
</div>
