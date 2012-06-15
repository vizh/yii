<div id="large-left">
  <h1>Обложка журнала ROCID://</h1>
  <h2>Создай свою обложку!</h2><br>
  <form action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="cover-id" value="">
    <label>Изображение для обложки <input type="file" name="cover-photo"></label><br>
    <label>Основной заголовок
    <textarea rows="5" cols="80" name="cover-text-first"><?=$this->FirstText;?></textarea></label>
    <label>Подзаголовок
    <textarea rows="5" cols="80" name="cover-text-second"><?=$this->SecondText;?></textarea></label>
    <input type="submit" name="send" value="Создать!">
  </form>
  
  <h2>Пример</h2>
  <img src="/files/rocid-cover/base/rocid-cover.jpg" alt="Обложка rocID" width="500" height="708">
</div>

<?php echo $this->SideBar; ?>