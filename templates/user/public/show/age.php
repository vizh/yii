<tr>
  <td class="f">
      <?php if ($this->Sex == 2):?>
        Родилась:
      <?php else:?>
        Родился:
      <?php endif;?>
  </td>
  <td>
  <?php if ($this->Empty): ?>
    не указан
  <?php elseif ($this->OnlyYear  && $this->HideBirthdayYear == 0): ?>
    <?=$this->Year?> год
  <?php elseif ($this->WithMonth): ?>
    <?=$this->words['calendar']['months'][1][$this->Month]?> <?php if ($this->HideBirthdayYear == 0):?><?=$this->Year?> года<?php endif;?>
  <?php else: ?>
    <?=$this->Day?> <?=$this->words['calendar']['months'][2][$this->Month]?> <?php if ($this->HideBirthdayYear == 0):?><?=$this->Year?> года<?php endif;?>
  <?php endif; ?>
  </td>
</tr>