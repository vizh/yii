<form action="/event-register.html" class="registration">
  <h5 class="title">Регистрация</h5>
  <table class="table table-condensed">
    <thead>
      <tr>
        <th>Тип билета</th>
        <th class="t-right col-width">Цена</th>
        <th class="t-center col-width">Кол-во</th>
        <th class="t-right col-width">Сумма</th>
      </tr>
    </thead>
    <tbody>
      <tr data-price="100">
        <td>Посещение выставки</td>
        <td class="t-right"><span class="number">100</b> Р</td>
        <td class="t-center">
          <select class="input-mini form-element_select">
            <option value="0" selected>0</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
          </select>
        </td>
        <td class="t-right"><b class="number mediate-price">0</b> Р</td>
      </tr>
      <tr data-price="7000">
        <td>Участие в профильной программе</td>
        <td class="t-right"><span class="number">450&nbsp;000</span> Р</td>
        <td class="t-center">
          <select class="input-mini form-element_select">
            <option value="0" selected>0</option>
            <option value="1">1</option>
            <option value="2">2</option>
          </select>
        </td>
        <td class="t-right"><b class="number mediate-price">0</b> Р</td>
      </tr>
      <tr>
        <td colspan="4" class="t-right total">
          <span>Итого:</span> <b id="total-price" class="number">0</b> Р
        </td>
      </tr>
    </tbody>
  </table>
  <div class="clearfix">
    <button class="btn btn-small btn-info pull-right">Зарегистрироваться</button>
  </div>
</form>