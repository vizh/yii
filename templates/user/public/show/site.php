<tr>
  <td class="f i-site">Сайт:</td>
  <td>
  <?php foreach($this->Sites as $site): ?>
    <noindex><a href="http://<?=$site->Url?>" target="_blank" rel="nofollow">http://<?=$site->Url?></a></noindex>
    <?php if ($this->Size > 1): ?>
      <br />
    <?php endif; ?>
  <?php endforeach; ?>
  </td>
</tr>
