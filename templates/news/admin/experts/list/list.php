<section class="main">
  <a class="button positive" href="<?=RouteRegistry::GetAdminUrl('news', 'experts', 'add');?>"><span class="plus icon"></span>Добавить статью</a>
  <table class="news">
    <?=$this->News;?>
  </table>
</section>