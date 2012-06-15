<section class="main edit vacancyedit">
  <h2>Редактировать вакансию</h2>

  <form id="form_editjob" enctype="multipart/form-data" action="" method="post">
    <input type="hidden" value="<?=$this->VacancyStreamId;?>" name="vacancy_stream_id">

    <aside class="col-l">
      <input type="text" data-empty="<?=$this->words['news']['entertitle'];?>"
             class="title bordered" maxlength="250" name="data[title]"
             value="<?=htmlspecialchars($this->Title);?>" autocomplete="off">
      <div class="aftertitle">
        <strong>Сылка:</strong>
        <input autocomplete="off" class="bordered" type="text" maxlength="250" name="data[link]" value="<?=$this->Link;?>">
      </div>
      <div class="aftertitle salary">
        <h5>Минимальная и максимальная зарплата.</h5>
        <strong>От</strong>
        <input autocomplete="off" class="bordered" type="text" maxlength="5" name="data[salary_min]" value="<?=$this->SalaryMin;?>">
        <span>тыс. руб</span>
        <strong>До</strong>
        <input autocomplete="off" class="bordered" type="text" maxlength="5" name="data[salary_max]" value="<?=$this->SalaryMax;?>">
        <span>тыс. руб</span>
      </div>
      <!-- <a id="addimage" class="button addimage">Вставить изображение</a> -->
      <div class="main-block text bordered">
        <h4>Описание</h4>
        <div class="textarea-container">
          <textarea name="data[description]" class="applyTinyMce"><?=$this->Description;?></textarea>
        </div>
      </div>




    </aside>

    <aside class="col-r">
      <div class="pub bordered sidebar">
        <h4>Опубликовать</h4>
        <a id="button_save" class="button positive save big"><span class="icon check"></span>Сохранить</a>
        <a target="_blank"
           href="<?=RouteRegistry::GetUrl('job', 'stream', 'show', array('id' => $this->VacancyStreamId));?>"
           class="button preview big">Просмотреть</a>
        <div class="cl"></div>
        <div class="pub-status sub-element">
          <h5>Статус</h5>
          <select name="data[status]" class="bordered">
            <?foreach(VacancyStream::$Statuses as $key):?>
            <option value="<?=$key?>" <?=$key == $this->Status ? 'selected="selected"' : '';?> ><?=$this->words['status'][$key]?></option>
            <?endforeach;?>
          </select>
        </div>
        <div class="cl"></div>
        <div class="pub-date bordered-input sub-element">
          <h5>Дата публикации</h5>
          <input type="text" value="<?=$this->Date['mday'];?>" maxlength="2" size="2" name="data[day]" placeholder="ДД" class="span1">
          <select name="data[month]" class="bordered span2">
            <?foreach ($this->words['calendar']['months'][1] as $key => $value ):?>
            <option value="<?=$key?>" <?=$this->Date['mon'] == $key ? 'selected="selected"' : '';?>  ><?=$value?></option>
            <?endforeach;?>
          </select>
          <input type="text" value="<?=$this->Date['year'];?>" maxlength="4" size="4" name="data[year]" placeholder="ГГ" class="span1">&nbsp;в&nbsp;
          <input type="text" value="<?=$this->Date['hours'];?>" maxlength="2" size="2" name="data[h]" placeholder="ЧЧ" class="span1">
          <input type="text" value="<?=intval($this->Date['minutes']) < 10 ? '0' . $this->Date['minutes'] : $this->Date['minutes'];?>" maxlength="2" size="2" name="data[min]" placeholder="ММ" class="span1">
        </div>
        <div class="cl"></div>
        <?if ($this->Status != VacancyStream::StatusPublish):?>
        <a id="button_publish" class="button publish big">Опубликовать</a>
        <div class="cl"></div>
        <?endif;?>
      </div>

      
    </aside>
  </form>
</section>