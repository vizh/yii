<?
$data = CHtml::encodeArray($this->Comission->attributes);
?>
<div class="row">
  <div class="span16">
    <form action="" method="post">
      <fieldset>
        <legend>Редактирование комиссии</legend>
        <div class="clearfix">
          <label for="Comission[Title]">Название</label>
          <div class="input">
            <input type="text" name="Comission[Title]" id="Comission[Title]" class="span10" value="<?=$data['Title'];?>">
          </div>
        </div>

        <div class="clearfix">
          <label for="Comission[Description]">Описание</label>
          <div class="input">
            <textarea rows="3" name="Comission[Description]" id="Comission[Description]" class="span10"><?=$data['Description'];?></textarea>
              <span class="help-block">
                Можно использовать html-теги.
              </span>
          </div>
        </div>

        <div class="clearfix">
          <label for="Comission[Url]">Внешняя ссылка</label>
          <div class="input">
            <input type="text" name="Comission[Url]" id="Comission[Url]" class="span10" value="<?=$data['Url'];?>">
          </div>
        </div>

        <div class="actions">
          <input type="submit" value="Сохранить" class="btn primary">&nbsp;
          <a href="<?=RouteRegistry::GetAdminUrl('comission', '', 'index');?>" class="btn">Отмена</a>
        </div>

      </fieldset>
    </form>
  </div>
</div>
 
