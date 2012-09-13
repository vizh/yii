<?php if (!empty($this->action->error)):?>
    <div class="alert alert-error"><?php echo $this->action->error;?></div>
<?php endif;?>

<form method="post" class="">
  <div class="row">
      <div class="span12 indent-bottom2">
          <h2>Выставление счета для <?php echo $this->action->payer->GetFullName();?></h2>
      </div>
  </div>
  <div class="row">
      <div class="span7 indent-bottom3">
          <table class="table table-striped">
              <tr>
                  <th>Получатель</th>
                  <th>Товар</th>
                  <th>Цена</th>
              </tr>
              <?php foreach ($orderItems as $orderItem):?>
                  <tr>
                      <td><?php echo $orderItem->Owner->GetFullName();?></td>
                      <td><?php echo $orderItem->Product->Title;?></td>
                      <td><?php echo $orderItem->PriceDiscount();?> руб.</td>
                  </tr>
              <?php endforeach;?>
          </table>
      </div>
  </div>
  <div class="row">
      <div class="span7">
          <div class="control-group">
              <label class="control-label">Название компании:</label>
              <div class="controls">
                  <input type="text" name="CreateOrder[Name]" class="span7" value="<?php if ( isset ($_REQUEST['CreateOrder']['Name'])) echo $_REQUEST['CreateOrder']['Name'];?>" />
              </div>
          </div>

          <div class="control-group">
              <label class="control-label">Юридический адрес (с индексом):</label>
              <div class="controls">
                  <textarea name="CreateOrder[Address]" class="span7"><?php if ( isset ($_REQUEST['CreateOrder']['Address'])) echo $_REQUEST['CreateOrder']['Address'];?></textarea>
              </div>
          </div>

          <div class="control-group">
              <label class="control-label">ИНН:</label>
              <div class="controls">
                  <input type="text" name="CreateOrder[INN]" class="span7" value="<?php if ( isset ($_REQUEST['CreateOrder']['INN'])) echo $_REQUEST['CreateOrder']['INN'];?>"/>
              </div>
          </div>

          <div class="control-group">
              <label class="control-label">КПП:</label>
              <div class="controls">
                  <input type="text" name="CreateOrder[KPP]" class="span7" value="<?php if ( isset ($_REQUEST['CreateOrder']['KPP'])) echo $_REQUEST['CreateOrder']['KPP'];?>" />
              </div>
          </div>

          <div class="control-group">
              <label class="control-label">Телефон:</label>
              <div class="controls">
                  <input type="text" name="CreateOrder[Phone]" class="span7" value="<?php if ( isset ($_REQUEST['CreateOrder']['Phone'])) echo $_REQUEST['CreateOrder']['Phone'];?>"/>
              </div>
          </div>

          <div class="control-group">
              <label class="control-label">Факс:</label>
              <div class="controls">
                  <input type="text" name="CreateOrder[Fax]" class="span7" value="<?php if ( isset ($_REQUEST['CreateOrder']['Fax'])) echo $_REQUEST['CreateOrder']['Fax'];?>" />
              </div>
          </div>

          <div class="control-group">
              <label class="control-label">Почтовый адрес (с индексом):</label>
              <div class="controls">
                  <textarea name="CreateOrder[PostAddress]" class="span7"><?php if ( isset ($_REQUEST['CreateOrder']['PostAddress'])) echo $_REQUEST['CreateOrder']['PostAddress'];?></textarea>
              </div>
          </div>
      </div>
  </div>
  <div class="row">
      <div class="span7"><input type="submit" name="" value="Выставить счет" class="btn btn-primary" /></div>
  </div>
</form>