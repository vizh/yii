<?$this->beginContent('/layouts/mail/runetid');?>
  <div class="column" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; width: 450px; float: left; margin: 0; padding: 0;">
    <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; width: 100%; margin: 0; padding: 0;"><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;"><td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 10px 20px 30px; font-size: 14px;">
          <?=$content;?>
        </td>
      </tr></table></div>

  <div class="column column-left" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; width: 220px; float: left; margin: 0; padding: 0;">
    <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; width: 100%; margin: 0; padding: 0;"><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;"><td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 10px 20px 30px;">
          <p style="font-family: 'HelveticaNeue-Light', 'Helvetica Neue Light', 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; line-height: 1.1; color: #000; font-weight: 900; font-size: 17px; padding-bottom: 10px;">Ваш профиль:</p>
          <img src="http://<?=RUNETID_HOST;?><?=$this->user->getPhoto()->get200px();?>" border="0" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; max-width: 100%; margin: 0; padding: 0;" /><h4 style="font-family: 'HelveticaNeue-Light', 'Helvetica Neue Light', 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; line-height: 1.1; color: #000; font-weight: 500; font-size: 23px; margin: 10px 0; padding: 0;"><?=$this->user->getFullName();?></h4>
          <?if ($this->user->getEmploymentPrimary() !== null && $this->user->getEmploymentPrimary()->Company !== null):?>
            <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-weight: normal; font-size: 14px; line-height: 1.6; margin: 0 0 5px; padding: 0;"><?=$this->user->getEmploymentPrimary()->Company->Name;?></p>
          <?endif;?>
          <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-weight: normal; font-size: 14px; line-height: 1.6; margin: 0 0 5px; padding: 0;"><a href="<?=$this->user->getUrl();?>" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; color: #2BA6CB; margin: 0; padding: 0;">Открыть профиль</a></p>
          <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-weight: normal; font-size: 14px; line-height: 1.6; margin: 0 0 5px; padding: 0;"><a href="<?=$this->user->getFastauthUrl('/user/edit/');?>" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; color: #2BA6CB; margin: 0; padding: 0;">Редактировать</a></p>
        </td>
      </tr></table></div>
  <div class="clear" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; display: block; clear: both; margin: 0; padding: 0;"></div>
<?$this->endContent();?>