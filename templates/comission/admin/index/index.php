<div class="row">
  <div class="span16">
    <?if (!empty($this->Comissions)):?>
    <table>
      <thead>
      <tr>
        <th>Комиссия</th>
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

<hr>

<div class="row">
  <div class="span16">
      <a href="<?=RouteRegistry::GetAdminUrl('comission', '', 'edit');?>" class="btn btn-primary"><span class="plus icon"></span>Добавить комиссию</a>
  </div>
</div>