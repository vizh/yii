<div class="row">
  <div class="span16">
    <h1>Информация о бронировании номеров на РИФ+КИБ</h1>

    <form class="form-stacked" action="" method="post">
      <fieldset>
        <div class="clearfix">
          <label for="hotel">Выберите пансионат</label>
          <div class="input">
            <select class="span6" name="hotel" id="hotel">
              <option value="">Пансионат не выбран</option>
              <option value="ЛЕСНЫЕ ДАЛИ">ЛЕСНЫЕ ДАЛИ</option>
              <option value="ПОЛЯНЫ">ПОЛЯНЫ</option>
              <option value="НАЗАРЬЕВО">НАЗАРЬЕВО</option>
            </select>
          </div>
        </div>
      </fieldset>

      <fieldset>
        <div class="clearfix">
          <input type="submit" class="btn primary" value="Продолжить">
        </div>
      </fieldset>
    </form>
  </div>

  <div class="span16">
    <h3><?=$this->Hotel;?></h3>
    <table class="room-product">
      <thead>
      <tr>
        <th>Id в базе</th>
        <th>Корпус</th>
        <th>Категория</th>
        <th>Номер</th>
        <th>Цена</th>
        <th>&nbsp;</th>
        <th>17 - 18 апреля</th>
        <th>18 - 19 апреля</th>
        <th>19 - 20 апреля</th>
        <th>Управление</th>
      </tr>
      </thead>
      <tbody>
      <?=$this->Products;?>
      </tbody>
    </table>
  </div>
</div>