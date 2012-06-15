<section class="main">
  <a class="button positive" href="/admin/news/add/"><span class="plus icon"></span>Добавить новость</a>
  <table class="news">
    <!--<tr>
      <th>Новость</th>
      <th>Опубликовано</th>
      <th>Инфо</th>
      <th class="controls">Управление</th>
    </tr>-->
    <?=$this->News;?>
  </table>

  <? echo $this->Paginator;?>
</section>