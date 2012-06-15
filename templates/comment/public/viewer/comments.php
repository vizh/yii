<div class="event-comments">
  <?if ($this->Count > 0):?>
  <h2><?=$this->Count;?> <?=Yii::t('app', 'комментарий|комментария|комментариев|комментария', $this->Count);?></h2>
  <?endif;?>

  <?php echo $this->Comments;?>

  <div  class="leave-comment">
    <?if ($this->IsLogin): ?>
    <a id="leave-comment" href="">Оставить комментарий</a>

    <div id="comment-form">
      <div class="av">
        <img alt="<?=$this->FirstName;?> <?=$this->LastName;?>" title="<?=$this->FirstName;?> <?=$this->LastName;?>" src="<?=$this->UserPhoto;?>">
      </div>
      <div class="sbj">
        <form action="/comment/add/" method="post">
          <input type="hidden" name="objectId" value="<?=$this->ObjectId;?>">
          <input type="hidden" name="objectType" value="<?=$this->ObjectType;?>">
          <input type="hidden" name="backUrl" value="<?=$this->BackUrl;?>">
          <textarea name="comment"></textarea>

          <a href="" class="post-comment" id="post-comment">Комментировать</a>
        </form>
        <div class="clear"></div>
      </div>
    </div>
    <?else:?>
      <p>Чтобы оставить комментарий - <a id="comment_auth" href="/">авторизуйтесь</a></p>
    <?endif;?>
  </div>


  <div class="clear"></div>
  <!-- end event-comments -->
</div>
