<section class="main">
  <form class="form-search m-bottom_20">
    <input type="text" value="<?php if (isset($this->Search)):?><?php echo $this->Search['Query'];?><?php endif;?>" placeholder="Название мероприятия" name="Search[Query]"/> <input type="submit" name="" value="Искать" class="btn"/>
  </form>
  
  <a class="button positive" href="<?=RouteRegistry::GetAdminUrl('event', '', 'new');?>"><span class="plus icon"></span>Добавить мероприятие</a>
  <table class="events">
    <?=$this->Events;?>
  </table>
  <?php echo $this->Paginator;?>
</section>
