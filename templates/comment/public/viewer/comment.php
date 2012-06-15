<div class="event-comment-item lvl-0" <?=$this->First? 'style="border:none;"' : '';?>><a name="<?=$this->CommentId;?>"></a>
  <div class="av">
    <img src="<?=$this->UserPhoto;?>" alt="<?=htmlspecialchars($this->FirstName);?> <?=htmlspecialchars($this->LastName);?>" title="<?=htmlspecialchars($this->FirstName);?> <?=htmlspecialchars($this->LastName);?>" />
  </div>
  <div class="sbj">
    <div class="date"><?=$this->Date['mday'];?> <?=$this->words['calendar']['months'][2][$this->Date['mon']]?> <?=$this->Date['year']?></div>
    <div class="nm">
      <a href="/<?=$this->RocId;?>/"><?=htmlspecialchars($this->FirstName);?> <?=htmlspecialchars($this->LastName);?></a>
    </div>
    <?=$this->CommentContent;?>
    <div class="clear"></div>
    <?if($this->IsAdmin):?>
    <a href="/comment/delete/<?=$this->CommentId;?>/?backUrl=<?=urlencode($this->BackUrl);?>" style="padding-top:5px; color: #910917; display: block;"
        onclick="if (! confirm('Вы действительно хотите удалить комментарий?')) return false;">Удалить комментарий</a>
    <?endif;?>
  </div>
</div>