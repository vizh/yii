<div id="job_<?=$this->Id;?>" class="job">
  <dl>
    <dt>Компания:</dt>
    <dd><input type="text" name="company" value="<?=htmlspecialchars($this->CompanyName);?>" size="53"> <span class="required">(обязательное поле)</span></dd>
  </dl>
  <dl>
    <dt>Должность:</dt>
    <dd><input type="text" name="position" value="<?=htmlspecialchars($this->Position);?>" size="53"> <span class="required">(обязательное поле)</span></dd>
  </dl>
  <dl>
    <dt>Период работы:</dt>
    <dd>
      <select name="start_month" class="start_month">
        <option value="0">месяц</option>
        <?
        $months = $this->words['calendar']['months'][1];
        for($i=1;$i<=12;$i++):?>
          <option value="<?=$i;?>" <?= $i==$this->StartWorking['month']? 'selected' : '';?>><?=$months[$i];?></option>
        <?endfor;?>
      </select>
      <input type="text" name="start_year"
           value="<?=$this->StartWorking['year'] != 0 ?$this->StartWorking['year'] : '';?>" class="start_year" size="4">
        —
      <select name="end_month" class="end_month">
        <option value="0">н. в.</option>
        <?
        $months = $this->words['calendar']['months'][1];
        for($i=1;$i<=12;$i++):?>
          <option value="<?=$i;?>" <?= $i==$this->FinishWorking['month']? 'selected' : '';?>><?=$months[$i];?></option>
        <?endfor;?>
      </select>
      <input type="text" name="end_year" value="<?=$this->FinishWorking['year'] != 9999 && $this->FinishWorking['year'] != 0 ? $this->FinishWorking['year'] : '';?>"
             class="end_year" size="4" <?=$this->FinishWorking['month'] == 0 ? 'disabled="disabled"' : '';?> >
      <span class="required">(обязательное поле)</span>
    </dd>
  </dl>
  <dl>
    <dt>Приоритеты:</dt>
    <dd><label><input type="radio" name="work_priority" <?=$this->Primary == 1 ?'checked="checked"' : '';?> value=""> основное место работы</label></dd>
  </dl>
  <dl>
    <dt>&nbsp;</dt>
    <dd><a href="#deletejob" class="delete_work">удалить место работы</a></dd>
  </dl>
</div>

<?if (!$this->LastJob): ?>
<dl id="separator_<?=$this->Id;?>" class="bseparator">
  <dt>&nbsp;</dt>
  <dd>&nbsp;</dd>
</dl>
<?endif;?>
 
