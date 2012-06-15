<div class="row">
  <div class="span16">
    <a href="<?=RouteRegistry::GetAdminUrl('comission', '', 'edit');?>" class="button positive"><span class="plus icon"></span>Добавить комиссию</a>
  </div>
</div>
    <hr>
<div class="row">
  <div class="span16">
    <?if (!empty($this->Comissions)):?>
    <table>
      <thead>
      <tr>
        <th>Название</th>
        <th>Описание</th>
        <!--<th>Количество участников</th>-->
        <th>Управление</th>
      </tr>
      </thead>
      <tbody>
      <?php echo $this->Comissions;?>
      </tbody>
    </table>
    <?else:?>
    <?endif;?>
  </div>
</div>
