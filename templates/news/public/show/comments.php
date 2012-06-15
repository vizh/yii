<div class="event-comments">
  <h2>Комментарии <span>(<?=$this->Count;?>)</span></h2>

  <?php echo $this->Comments;?>

  <div  class="leave-comment">
    <?if ($this->IsLogin): ?>
    <a id="leave-comment" href="">Написать комментарий</a>

    <div id="comment-form">
      <div class="av">
        <img height="50" width="50" alt="<?=$this->FirstName;?> <?=$this->LastName;?>" title="<?=$this->FirstName;?> <?=$this->LastName;?>" src="<?=$this->UserPhoto;?>">
      </div>
      <div class="sbj">
        <form action="/news/comment/<?=$this->NewsPostId;?>/" method="post">
          <textarea name="comment"></textarea>

          <a href="" class="post-comment" id="post-comment">Комментировать</a>
        </form>
        <div class="clear"></div>
      </div>
    </div>
    <?else:?>
      <p>Чтобы оставить комментарий - <a href="/">авторизуйтесь</a></p>
    <?endif;?>
  </div>


  <div class="clear"></div>
  <!-- end event-comments -->
</div>
