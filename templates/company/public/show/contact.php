<tr>
  <td class="f"><?=$this->ContactName?>:</td>
  <td>
  <?php foreach ($this->Contact as $contact):?>
    <?=$contact?>
    <?php if ($this->Size > 1): ?>
      <br />
    <?php endif; ?>
  <?php endforeach; ?>
  </td>
</tr>
