<?
/** @var $items OrderItem[] */
$newItems = $this->NewItems;
?>

<div class="content pay">
  <table>
    <tr>
      <th class="product">Наименование услуги</th>
      <th class="user">Получатель</th>
      <th class="price">Цена</th>
      <th class="delete"></th>
    </tr>
    <?foreach ($newItems as $item):
    if ($item->Paid == 1) { continue; }
    ?>
    <tr>
      <td class="product"><?=$item->Product->Title;?></td>
      <td class="user"><?=$item->Owner->FirstName;?> <?=$item->Owner->LastName;?> (rocID: <?=$item->Owner->RocId;?>)</td>
      <td class="price"><?=number_format($item->PriceDiscount(), 0, '.', ' ');?> <?='руб.';?></td>
      <td class="delete"><a onclick="return alert('Удалить услугу?');" href="<?=RouteRegistry::GetUrl('main', '', 'delete', array('ItemId' => $item->OrderItemId));?>">Удалить</a></td>
    </tr>
    <?endforeach;?>

    <tr class="last">
      <td colspan="2"></td>
      <td class="price">Итого:<br><strong><?=number_format($this->Total, 0, '.', ' ');?> <?='руб.';//Yii::t('app', 'рубль|рубля|рублей|рубля', $this->Total);?></strong></td>
      <td class="delete"></td>
    </tr>
  </table>

  <h3>Заполните данные юр. лица</h3>

  <form id="jur_form" action="" method="post">
  <div class="cfldset">

    <label>Название компании:</label>
    <p><input type="text" value="<?=isset($this->Data['Name']) ? $this->Data['Name'] : '';?>" name="data[Name]"></p>

    <label>Юридический адрес (с индексом):</label>
    <p><textarea cols="80" rows="5" name="data[Address]"><?=isset($this->Data['Address']) ? $this->Data['Address'] : '';?></textarea></p>

    <label>ИНН:</label>
    <p><input type="text" value="<?=isset($this->Data['INN']) ? $this->Data['INN'] : '';?>" name="data[INN]"></p>

    <label>КПП:</label>
    <p><input type="text" value="<?=isset($this->Data['KPP']) ? $this->Data['KPP'] : '';?>" name="data[KPP]"></p>

    <label>Телефон:</label>
    <p><input type="text" value="<?=isset($this->Data['Phone']) ? $this->Data['Phone'] : '';?>" name="data[Phone]"></p>

    <label>Факс:</label>
    <p><input type="text" value="<?=isset($this->Data['Fax']) ? $this->Data['Fax'] : '';?>" name="data[Fax]"></p>

    <label>Почтовый адрес (с индексом):</label>
    <p><textarea cols="80" rows="5" name="data[PostAddress]"><?=isset($this->Data['PostAddress']) ? $this->Data['PostAddress'] : '';?></textarea></p>
    <!-- end cfldset -->
  </div>



  <div class="response">
    <a href="<?=RouteRegistry::GetUrl('main', '', 'index', array('eventId' => $this->EventId));?>">&larr; Назад</a>
    <a href="" onclick="$('#jur_form').submit(); return false;">Выставить счет</a>
    <div class="clear"></div>
  </div>
  </form>
</div>