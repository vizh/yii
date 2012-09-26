<?php
/** @var $event Event */
$event = $this->Event;
/** @var $eventUsers EventUser[] */
$eventUsers = $this->EventUsers;
?>
<tr>
  <td class="f"><a href="<?=RouteRegistry::GetUrl('event', '', 'show', array('idName' => $event->IdName));?>"><img src="<?=$event->GetMiniLogo();?>"  width="74" alt="" title="<?=$event->Name;?>" /></a></td>
  <td>
    <h3><?=$event->Name;?></h3>

    <?if (empty($this->EventProgramUserLinks) && sizeof($eventUsers) == 1):?>
    <p>
      <?=$eventUsers[0]->EventRole->Name;?>
    </p>
    <?else:?>
    <?if (sizeof($eventUsers) > 1):?>
      <?foreach ($eventUsers as $eUser):?>
        <p>
          <span class="day-title"><?=$eUser->Day->Title;?>:</span>
          &nbsp;<?=$eUser->EventRole->Name;?>
        </p>
        <?endforeach;?>
      <?endif;?>
    <?if (!empty($this->EventProgramUserLinks)):?>
      <?foreach ($this->EventProgramUserLinks as $userLink):
        /** @var $section EventProgram */
        $section = $userLink['section'];
        ?>
        <p>
          <a target="_blank" href="<?=!empty($this->Event->UrlProgramMask) ? str_replace(':SECTION_ID', $section->EventProgramId, $this->Event->UrlProgramMask) : (!empty($this->Event->UrlProgram) ? $this->Event->UrlProgram : '#');?>"><?=strip_tags($section->Title);?></a><br>
          <?=$userLink['role'];?>
        </p>
        <?endforeach;?>
      <?endif;?>
    <?endif;?>
  </td>
</tr>