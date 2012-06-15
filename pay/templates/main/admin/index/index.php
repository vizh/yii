<div class="row">
  <div class="span16">
    <h1><?=$this->EventName;?></h1>
  </div>
  <div class="span16">
    <?if (!empty($this->Error)):?>
    <div class="alert-message error">
      <p><strong>Возникла ошибка!</strong> <?=$this->Error;?></p>
    </div>
    <?elseif (! empty($this->Result)):?>
    <div class="alert-message success">
      <p><strong>Выполнено!</strong> <br> <?=$this->Result;?></p>

      <p><a target="_blank" href="<?=$this->CsvUrl;?>">Скачать файл со скидками.</a></p>
    </div>
    <?endif;?>
  </div>
  <div class="span16">
    <h2>Генерация скидок</h2>

    <form action="" method="post">
      <fieldset>
        <div class="clearfix">
          <label for="count">Количество промо-кодов</label>
          <div class="input">
            <input type="text" size="30" name="count" id="count" class="span2"><span class="help-inline">штук</span>
          </div>
        </div>

        <div class="clearfix">
          <label for="discount">Размер скидки</label>
          <div class="input">
            <select id="discount" name="discount" class="span2">
              <?foreach ($this->Discounts as $key => $value):?>
              <option value="<?=$key;?>"><?=$key;?></option>
              <?endforeach;?>
            </select>
          </div>
        </div>

        <div class="clearfix">
          <label for="product">Товар</label>
          <div class="input">
            <select id="product" name="product" class="span6">
              <option value="0">Товар не выбран</option>
              <?foreach ($this->Products as $product):?>
              <option value="<?=$product->ProductId;?>"><?=$product->Title;?></option>
              <?endforeach;?>
            </select>
            <span class="help-block">
              <strong>Внимание!</strong> Для 100% скидки выбор товара обязателен. В остальных случаях можно оставить поле пустым и скидка применится ко всем товарам мероприятия.
            </span>
          </div>
        </div>
      </fieldset>

      <fieldset>
        <div class="clearfix">
          <input type="submit" value="Генерировать промо коды" class="btn primary">
        </div>
      </fieldset>
    </form>
  </div>
</div>