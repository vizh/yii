<tr>
  <td class="f"><a href="<?=RouteRegistry::GetUrl('event', '', 'show', array('idName' => $this->IdName));?>"><img src="<?=$this->Logo?>"  width="74" alt="" title="<?=$this->Name?>" /></a></td>
  <td>
    <h3><?=$this->Name?></h3>

      <?if (isset($this->Role)):?>
      <p>
        <?=$this->Role?>
      </p>
      <?elseif (isset($this->EventProgramUserLinks)):?>
        <?foreach ($this->EventProgramUserLinks as $userLink):
      /** @var $section EventProgram */
      $section = $userLink['section'];
      ?>
        <p>
          <a target="_blank" href="<?=!empty($this->UrlProgramMask) ? str_replace(':SECTION_ID', $section->EventProgramId, $this->UrlProgramMask) : (!empty($this->UrlProgram) ? $this->UrlProgram : '#');?>"><?=strip_tags($section->Title);?></a><br>
          <?=$userLink['role'];?>
        </p>
        <?endforeach;?>
      <?else:?>
        <p>статус участника мероприятия не установлен</p>
      <?endif;?>
  </td>
</tr>