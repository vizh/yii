<tr>
  <td class="f <?=$this->Class?>"><?=$this->ContactName?>:</td>
  <td>
  <?php foreach ($this->Contact as $contact):?>
    <?if(!empty($this->Link)):?>
      <a href="<?=str_replace("##", $contact, $this->Link)?>" target="_blank"><?=$contact?></a>
    <?else:?>
      <?=$contact?>
    <?endif;?>
    <?php if ($this->Size > 1): ?>
      <br />
    <?php endif; ?>
  <?php endforeach; ?>
  </td>
</tr>
