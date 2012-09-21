<h2>Контакты</h2>
<form class="well" method="POST">
  <div class="row m-bottom_10">
    <div class="span4">
      <label><input type="radio" value="rocid" name="Contacts[By]" checked="checked" /> <span class="label">по rocID</span></label>
      <label><input type="radio" value="email" name="Contacts[By]" /> <span class="label">по Email</span></label>
    </div>
  </div>
  <div class="row">
    <div class="span8">
      <textarea class="span8" style="height: 200px" name="Contacts[Data]"><?php if (isset($this->Data)):?><?php echo $this->Data;?><?php endif;?></textarea>
    </div>
    <div class="span4">
      <label>
        <input type="radio" name="Contacts[Format]" value="table" checked="checked" /> <span class="label label-info">Таблица</span>
      </label>
      <label>
        <input type="radio" name="Contacts[Format]" value="name email" /> <span class="label label-info">"Имя Фамилия" &lt;email@domain.com&gt;</span>
      </label>
      <label>
        <input type="radio" name="Contacts[Format]" value="email" /> <span class="label label-info">email@domain.com</span>
      </label>
    </div>
  </div>
  <input type="submit" name="" value="Получить" class="btn"/>
</form>

<?php if (isset($this->Data)):?>
<div class="row m-top_20">
  <div class="span10">
    <?php if (!empty($this->Errors)):?>
      <div class="alert alert-error">
        <?php foreach ($this->Errors as $error):?>
          <?php echo $error.'<br/>';?>
        <?php endforeach;?>
      </div>
    <?php endif;?>
    <?php if (!empty($this->Users)):?>
      <h3>Результат запроса:</h3>
      <?php if ($this->Format == 'table'):?>
        <table class="table">
          <thead>
            <th>ROCID</th>
            <th>Фамилия</th>
            <th>Имя</th>
            <th>Контактный Email</th>
          </thead>
          <tbody>
          <?php foreach ($this->Users as $user):?>
            <tr>
              <td><?php echo $user->RocId;?></td>
              <td><?php echo $user->LastName;?></td>
              <td><?php echo $user->FirstName;?></td>
              <td><?php echo $user->GetEmail()->Email;?></td>
            </tr>
          <?php endforeach;?>
          </tbody>
        </table>
      <?php else:?>
        <?php $result = '';?>
        <?php foreach ($this->Users as $user):?>
          <?php switch($this->Format)
          {
            case 'name email':
              $result .= '"'.$user->GetFullName().'" &lt;'.$user->GetEmail()->Email.'&gt;,';
              break;

            case 'email':
              $result .= $user->GetEmail()->Email.',';
              break;
          }?>
        <?php endforeach;?>
      <textarea readonly="readonly" class="span10" onclick="this.select();"><?php echo $result;?></textarea>
      <?php endif;?>
    <?php endif;?>
  </div>
</div>
<?php endif;?>