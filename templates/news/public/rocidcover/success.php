<div id="large-left">
  <h1>Сгенерированная обложка журнала ROCID://</h1>
  <img width="500" height="708" src="<?=$this->CoverImage;?>" alt="Обложка rocID">
  <?if(! empty($this->HtmlCode)):?>
  <br>
  <label>HTML-код:<br>
    <textarea rows="3" cols="80" readonly="readonly"><?=htmlspecialchars($this->HtmlCode);?></textarea>
  </label>
  <?endif;?>
  <?if(! empty($this->HtmlCode)):?>
  <label>BB-код:<br>
    <textarea rows="3" cols="80" readonly="readonly"><?=htmlspecialchars($this->BbCode);?></textarea>
  </label>
  <?endif;?>
</div>

 

<?php echo $this->SideBar; ?>