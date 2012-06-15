<section class="main">
  <a class="button positive" href="<?=RouteRegistry::GetAdminUrl('settings', 'mask', 'new');?>"><span class="plus icon"></span>Добавить маску</a>
  <table class="news">
    <?=$this->Masks;?>
  </table>
</section>
