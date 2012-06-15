<section class="main">
  <a class="button positive" href="<?=RouteRegistry::GetAdminUrl('event', '', 'new');?>"><span class="plus icon"></span>Добавить мероприятие</a>
  <table class="events">
    <?=$this->Events;?>
  </table>
  <?php echo $this->Paginator;?>
</section>
