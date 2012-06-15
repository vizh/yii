<div class="row">
  <div class="span16">
    <a href="<?=RouteRegistry::GetAdminUrl('comission', 'vote', 'add');?>" class="button positive"><span class="plus icon"></span>Новое голосование</a>
  </div>
</div>
    <hr>
<div class="row">
  <div class="span16">
    <?if (!empty($this->Votes)):?>
    <table>
      <thead>
      <tr>
        <th>Название</th>
        <th>Описание</th>
        <th>Комиссия</th>
        <th>Статус</th>
        <th>Управление</th>
      </tr>
      </thead>
      <tbody>
      <?php echo $this->Votes;?>
      </tbody>
    </table>
    <?else:?>
    <?endif;?>
  </div>
</div>